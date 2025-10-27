<?php

namespace App\Traits;

use App\Constants\Status;
use App\Events\ReceiveMessage;
use App\Events\UserOnlineStatusChanged;
use App\Models\Message;
use App\Models\MessageMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait MessageManager
{
    public function index($username = null)
    {
        $pageTitle = 'Messages';
        $user      = auth()->user();

        $sidebar = $this->getChatSidebar($user);

        $unreadCounts = $sidebar['unreadCounts'];

        $chatUsers = $sidebar['chatUsers']->map(function ($chatUser) use ($sidebar) {
            $latest                    = $sidebar['latestMessages']->get($chatUser->id);
            $chatUser->last_message_at = $latest['at'] ?? now()->subYears(10);
            $chatUser->unread_count    = $sidebar['unreadCounts']->get($chatUser->id) ?? 0;
            $chatUser->is_online       = $chatUser->isOnline();
            return $chatUser;
        })->sortByDesc('last_message_at')->values();

        $activeUser = null;
        $messages   = collect();

        if ($username) {
            $activeUser = User::where('username', $username)->firstOrFail();
            $messages   = Message::where(function ($q) use ($user, $activeUser) {
                $q->where('from_id', $user->id)->where('to_id', $activeUser->id);
            })
                ->orWhere(function ($q) use ($user, $activeUser) {
                    $q->where('from_id', $activeUser->id)->where('to_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            $activeUser->is_online = $activeUser->isOnline();

        }

        return view('Template::user.message.index', compact(
            'pageTitle',
            'chatUsers',
            'activeUser',
            'messages',
            'user',
            'unreadCounts'
        ));
    }

    public function fetchMessages(Request $request, $userId = null)
    {
        $authId = auth()->user()->id;
        $userId = $userId ?: $request->query('userId');
        $page   = $request->query('page', 1);

        if (!$userId) {
            return response()->json(['error' => 'User ID is required']);
        }

        $friend = User::active()->find($userId);
        if (!$friend) {
            $message = 'Sorry the user not found';
            return responseManager('not_found', $message);
        }

        $query = Message::with(['sender', 'images'])
            ->where(function ($q) use ($authId, $userId) {
                $q->where('from_id', $authId)->where('to_id', $userId);
            })->orWhere(function ($q) use ($authId, $userId) {
            $q->where('from_id', $userId)->where('to_id', $authId);
        });

        if (isApiRequest()) {
            $messages = $query->orderBy('created_at', 'desc')->paginate();
            $notify[] = 'Users messages';
            return apiResponse('fetch_message', 'success', $notify, [
                'messages'    => $messages,
                'profilePath' => getFilePath('userProfile'),
                'mediaPath'   => getFilePath('messageImage'),
                'more'        => $messages->hasMorePages(),
                'friend'      => $friend,
            ]);
        } else {
            $messages = $query->orderBy('created_at', 'desc')->paginate(getPaginate(), ['*'], 'page', $page);

            $reversedMessages = $messages->getCollection()->reverse();

            $html = '';
            foreach ($reversedMessages as $message) {
                $html .= view('Template::user.message.single_message', [
                    'message'       => $message,
                    'currentUserId' => $authId,
                ])->render();
            }

            return response()->json([
                'html'         => $html,
                'hasMorePages' => $messages->hasMorePages(),
                'currentPage'  => $messages->currentPage(),
            ]);
        }
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'to_id'   => 'required|exists:users,id',
            'message' => 'nullable|string',
            'media' => 'nullable|array',
            'media.*' => 'required|mimes:jpeg,png,jpg,mp4,mov,webm',
        ], [
            'to_id.required' => 'Recipient is required',
            'to_id.exists'   => 'Recipient does not exist',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        if (empty($request->message) && empty($request->media)) {
            $notify[] = 'Message or image is required';
            return apiResponse("validation_error", "error", $notify);
        }

        $sender   = auth()->user();
        $receiver = User::find($request->to_id);

        if (!$receiver) {
            $notify[] = "Receiver not found";
            return apiResponse('not_found', 'error', $notify, [
                'success' => false,
            ]);
        }

        if (!$receiver->status) {
            $notify[] = "Receiver is not available at this moment";
            return apiResponse('not_found', 'error', $notify, [
                'success' => false,
            ]);
        }

        $message                  = new Message();
        $message->from_id         = $sender->id;
        $message->to_id           = $request->to_id;
        $message->message         = $request->message;
        $message->last_message_at = now();
        $message->is_read         = Status::NO;
        $message->save();

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                try {
                    $messageImage             = new MessageMedia();
                    $messageImage->message_id = $message->id;
                    $messageImage->image      = fileUploader($file, getFilePath('messageImage'), getFileSize('messageImage'));

                    $mimeType = $file->getClientMimeType();

                    if (str_starts_with($mimeType, 'image/')) {
                        $messageImage->is_video = Status::IMAGE;
                    } elseif (str_starts_with($mimeType, 'video/')) {
                        $messageImage->is_video = Status::VIDEO;
                    } else {
                        $messageImage->is_video = Status::IMAGE;
                    }

                    $messageImage->save();
                    info($messageImage->is_video);
                } catch (\Exception $exp) {
                    $notify[] = ['errors', 'Image could not be uploaded'];
                    return back()->withNotify($notify);
                }
            }
        }

        $message->load('images');


        if ($request->input(('active_user_id') == $receiver->id)) {
            Message::where('from_id', $receiver->id)
                ->where('to_id', $sender->id)
                ->where('is_read', Status::NO)
                ->update(['is_read' => Status::YES]);
        }

        $htmlForSender   = null;
        $htmlForReceiver = null;

        if (!isApiRequest()) {

            $htmlForSender = view('Template::user.message.single_message', [
                'message'       => $message,
                'currentUserId' => $sender->id,
            ])->render();

            $htmlForReceiver = view('Template::user.message.single_message', [
                'message'       => $message,
                'currentUserId' => $receiver->id,
            ])->render();

        }

        event(new ReceiveMessage([
            info('message_send'),
            'sender'   => $sender->id,
            'receiver' => $receiver->id,
            'message'  => $message,
            'html'     => $htmlForReceiver,
        ]));

        return responseManager('message_send', 'success', 'success', [
            'html'    => $htmlForSender,
            'message' => $message,
            'image_path' => getFilePath('messageImage'),
            'success' => true,
        ]);
    }

    public function markAsRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return apiResponse("validation_error", "error", $validator->errors()->all());
        }

        $authId = auth()->user()->id;

        $messages = Message::where('from_id', $request->user_id)
            ->where('to_id', $authId)
            ->where('is_read', Status::NO)
            ->get();

        foreach ($messages as $message) {
            $message->is_read = Status::YES;
            $message->save();
        }

        $notify[] = 'Messages marked as read';
        return apiResponse('message_mark_as_read', 'success', $notify, [
            'success' => true,
        ]);
    }

    public function fetchSidebar(Request $request)
    {
        $user    = auth()->user();
        $sidebar = $this->getChatSidebar($user, $request->input('activeUserId'));

        $chatUsers = $sidebar['chatUsers']->map(function ($chatUser) use ($sidebar) {
            $latest = $sidebar['latestMessages']->get($chatUser->id);

            $chatUser->last_message_time = $latest['at'] ?? now()->subYears(10);
            $chatUser->last_message_at   = $latest['at'] ? diffForHumans($latest['at']) : null;
            $chatUser->last_message      = $latest['text'] ?? null;
            $chatUser->unread_count      = $sidebar['unreadCounts']->get($chatUser->id) ?? 0;
            $chatUser->is_online         = $chatUser->isOnline();

            return $chatUser;
        })->sortByDesc('last_message_time')->values();

        if (isApiRequest()) {
            $notify[] = 'Users Chat List';
            return apiResponse('message chat list', 'success', $notify, [
                'chatUsers'    => $chatUsers,
                'activeUser'   => $sidebar['activeUser'],
                // 'unreadCounts' => $sidebar['unreadCounts'],
                'image_path'   => getFilePath('userProfile'),
            ]);
        }

        $view = 'Template::partials.chat_list';
        $html = view($view, [
            'chatUsers'    => $chatUsers,
            'activeUser'   => $sidebar['activeUser'],
            'unreadCounts' => $sidebar['unreadCounts'],
        ])->render();

        return response()->json([
            'view' => $html,
        ]);
    }

    private function getChatSidebar($user, $activeUserId = null)
    {
        $conversationPartners = Message::where('from_id', $user->id)
            ->orWhere('to_id', $user->id)
            ->select('from_id', 'to_id')
            ->get()
            ->flatMap(function ($message) use ($user) {
                return [
                    $message->from_id == $user->id ? $message->to_id : $message->from_id,
                ];
            })
            ->unique()
            ->filter(fn($id) => $id != $user->id)
            ->values();

        $activeUser = null;
        if ($activeUserId) {
            $activeUser = User::find($activeUserId);
            if ($activeUser && !$conversationPartners->contains($activeUser->id)) {
                $conversationPartners->push($activeUser->id);
            }
        }

        $latestMessages = Message::where(function ($query) use ($user, $conversationPartners) {
            $query->where('from_id', $user->id)->whereIn('to_id', $conversationPartners);
        })
            ->orWhere(function ($query) use ($user, $conversationPartners) {
                $query->where('to_id', $user->id)->whereIn('from_id', $conversationPartners);
            })
            ->latest('last_message_at')
            ->get()
            ->groupBy(function ($message) use ($user) {
                return $message->from_id == $user->id ? $message->to_id : $message->from_id;
            })
            ->map(function ($group) {
                $latest = $group->sortByDesc('last_message_at')->first();
                return [
                    'text' => $latest->message ?? null,
                    'at'   => $latest->last_message_at,
                ];
            });

        $unreadCounts = Message::where('to_id', $user->id)
            ->whereIn('from_id', $conversationPartners)
            ->where('is_read', Status::NO)
            ->groupBy('from_id')
            ->selectRaw('from_id, count(*) as unread_count')
            ->pluck('unread_count', 'from_id');

        $chatUsers = User::whereIn('id', $conversationPartners)->get();

        return [
            'conversationPartners' => $conversationPartners,
            'activeUser'           => $activeUser,
            'latestMessages'       => $latestMessages,
            'unreadCounts'         => $unreadCounts,
            'chatUsers'            => $chatUsers,
        ];
    }

    public function updateOnlineStatus()
    {
        $user = auth()->user();
        $user->updateLastSeen();
        event(new UserOnlineStatusChanged($user->id, true));
        return apiResponse('online', 'success', ['success']);
    }

    public function onlineUsers()
    {
        $onlineThreshold = now()->subMinutes(5);
        $users = User::where('last_seen', '>=', $onlineThreshold)->get();

        $notify[] = 'Online Users';
        return apiResponse('online_users', 'success', $notify, [
            'users' => $users,
            'image_path' => getFilePath('userProfile'),
        ]);
    }

    public function downloadMedia($id)
    {
        $media = MessageMedia::find($id);
        if (!$media) {
            return responseManager('not_found', 'Media not found');
        }
        $filePath = getFilePath('messageImage') . "/" . $media->image;

        if (!file_exists($filePath)) {
            return responseManager('not_found', 'Media not found');
        }
        return response()->download($filePath);
    }

}
