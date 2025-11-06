<?php

namespace App\Traits;

use App\Constants\Status;
use App\Models\Short;
use App\Models\User;
use Illuminate\Http\Request;

trait FriendsManager
{
    public function index()
    {
        $pageTitle = 'Friends';
        $following = auth()->user()->followings->pluck('id')->toArray();

        $query = User::active()->with([
            'shorts' => function ($q) {
                $q->approved()
                    ->published()
                    ->publicShort()
                    ->where(function ($query) {
                        $query->where('storage_driver', 'local')
                            ->orWhereIn('storage_driver', function ($subQuery) {
                                $subQuery->select('alias')
                                    ->from('storage_settings')
                                    ->where('status', Status::ENABLE);
                            });
                    })
                    ->orderBy('id', 'desc');
            },
        ]);
        $users = $query->paginate(getPaginate());

        $users->getCollection()->transform(function ($user) {
            if ($user->shorts->isNotEmpty()) {
                $user->shorts[0] = prepareShortData($user->shorts[0]);
            }
            return $user;
        });

        $view = 'Template::user.friend.index';
        return responseManager("friends", 'friends', 'success', [
            'view'      => $view,
            'pageTitle' => $pageTitle,
            'following' => $following,
            'users'     => $users,
            'imagePath' => getFilePath('userProfile'),
        ]);
    }

    public function friendList()
    {
        $query = User::active()
            ->where('id', '!=', auth()->id())
            ->searchable(['username']);
        $users     = $query->paginate(getPaginate());
        $following = auth()->user()->followings->pluck('id')->toArray();

        $data = isApiRequest() ? $users : view('Template::user.friend.users_list', compact('users', 'following'))->render();
        return apiResponse("friends", 'success', ['friends'], [
            'data'         => $data,
            'hasMorePages' => $users->hasMorePages(),

        ]);
    }

    public function follow($id)
    {
        if (!auth()->check()) {
            return apiResponse("follow", 'error', ['unauthenticated'], []);
        }

        $user = User::find($id);
        if (!$user) {
            return apiResponse("follow", 'error', ['user not found'], []);
        }
        if ($user->id == auth()->user()->id) {
            return apiResponse("follow", 'error', ['you can not follow yourself'], []);
        }
        auth()->user()->followings()->syncWithoutDetaching([$user->id]);
        return responseManager("follow", 'You have followed ' . $user->username, 'success', []);
    }

    public function unfollow($id)
    {
        if (!auth()->check()) {
            return apiResponse("unfollow", 'error', ['unauthenticated'], []);
        }

        $user = User::find($id);
        if (!$user) {
            return apiResponse("unfollow", 'error', ['user not found'], []);
        }
        if ($user->id == auth()->user()->id) {
            return apiResponse("unfollow", 'error', ['you can not unfollow yourself'], []);
        }
        auth()->user()->followings()->detach($user->id);
        return responseManager("unfollow", 'You have unfollowed ' . $user->username, 'success', []);
    }

    public function following()
    {
        $pageTitle = 'Following';

        $query = auth()->user()->followings()->with(['shorts' => function ($q) {
            $q->approved()
                ->published()
                ->publicShort()
                ->where(function ($query) {
                    $query->where('storage_driver', 'local')
                        ->orWhereIn('storage_driver', function ($subQuery) {
                            $subQuery->select('alias')
                                ->from('storage_settings')
                                ->where('status', Status::ENABLE);
                        });
                })
                ->orderBy('id', 'desc');
        }]);

        $users = $query->paginate(getPaginate());

        $users->getCollection()->transform(function ($user) {
            if ($user->shorts->isNotEmpty()) {
                $user->shorts[0] = prepareShortData($user->shorts[0]);
            }
            return $user;
        });

        $view = 'Template::user.friend.following';

        return responseManager("following", 'following', 'success', [
            'view'      => $view,
            'pageTitle' => $pageTitle,
            'users'     => $users,
            'imagePath' => getFilePath('userProfile'),
        ]);
    }

    public function followingList()
    {
        $query = auth()->user()->followings()->with(['shorts' => function ($q) {
            $q->approved()
                ->published()
                ->publicShort()
                ->latest();
        }]);

        $users = $query->paginate(getPaginate());

        $data = isApiRequest() ? $users : view('Template::user.friend.following_users', compact('users'))->render();

        return apiResponse("following", 'success', ['followings'], [
            'data'         => $data,
            'hasMorePages' => $users->hasMorePages(),
        ]);
    }

    public function followingShorts(Request $request)
    {
        $user         = auth()->user();
        $followingIds = $user->followings->pluck('id')->toArray();

        $shorts = Short::with('user')
            ->whereIn('user_id', $followingIds)
            ->approved()
            ->published()
            ->publicShort()
            ->where(function ($query) {
                $query->where('storage_driver', 'local')
                    ->orWhereIn('storage_driver', function ($subQuery) {
                        $subQuery->select('alias')
                            ->from('storage_settings')
                            ->where('status', Status::ENABLE);
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate();

        $shorts->transform(function ($short) use ($user) {
            if ($short->storage_driver === 'wasabi') {
                $fileUrl = getS3FileUri($short->name);
            } elseif ($short->storage_driver === 'local') {
                $fileUrl = asset(getFilePath('shorts') . '/' . $short->name);
            } else {
                $fileUrl = route('short.file', $short->name);
            }

            $extension = pathinfo($short->name, PATHINFO_EXTENSION);

            $liked = false;
            if ($user) {
                $liked = $short->likes()->where('user_id', $user->id)->exists();
            }

            $short->file_url  = $fileUrl;
            $short->extension = $extension;
            $short->liked     = $liked;
            return $short;
        });

        return apiResponse("following_shorts", 'success', ['Following shorts'], [
            'shorts'     => $shorts,
            'coverImage' => getFilePath('coverImage'),
            'imagePath'  => getFilePath('userProfile'),
        ]);
    }

    public function followers(Request $request, $id)
    {
        $user      = User::findOrFail($id);
        $followers = $user->followers()->paginate(getPaginate());

        if (isApiRequest()) {
            return apiResponse("followers", 'success', ['followers'], [
                'data'      => $followers,
                'imagePath' => getFilePath('userProfile'),
            ]);
        }

        if ($request->ajax()) {
            return view('Template::user.friend.followers_list', compact('followers'))->render();
        }
    }

    public function followingUsers(Request $request, $id)
    {
        $user      = User::findOrFail($id);
        $following = $user->followings()->paginate(getPaginate());
        if ($request->ajax()) {
            return view('Template::user.friend.following_list', compact('following'))->render();
        }
    }

    public function newFollowers(Request $request)
    {
        $user = auth()->user();

        $newFollowers = $user->followers()
            ->wherePivot('created_at', '>=', now()->subDays(7))
            ->paginate(getPaginate());

        return apiResponse("new_followers", 'success', ['New followers'], [
            'data'         => $newFollowers,
            'hasMorePages' => $newFollowers->hasMorePages(),
        ]);
    }
}
