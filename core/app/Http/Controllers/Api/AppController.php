<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Language;
use App\Models\Short;
use App\Models\ShortShare;
use App\Models\ShortView;
use App\Models\User;
use App\Traits\StarManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\PersonalAccessToken;
use App\Traits\ShortDataTransform;

class AppController extends Controller {
    use StarManager;

    use ShortDataTransform;

    public function generalSetting() {
        $notify[] = 'General setting data';
        return apiResponse("general_setting", "success", $notify, [
            'general_setting'       => gs(),
            'social_login_redirect' => route('user.social.login.callback', ''),
        ]);
    }

    public function getCountries() {
        $countryData = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $notify[]    = 'Country List';

        foreach ($countryData as $k => $country) {
            $countries[] = [
                'country'      => $country->country,
                'dial_code'    => $country->dial_code,
                'country_code' => $k,
            ];
        }
        return apiResponse("country_data", "success", $notify, [
            'countries' => $countries,
        ]);
    }

    public function getLanguage($code) {
        $languages     = Language::get();
        $languageCodes = $languages->pluck('code')->toArray();

        if (!in_array($code, $languageCodes)) {
            $notify[] = 'Invalid code given';
            return apiResponse("invalid_code", "error", $notify);
        }

        $jsonFile = file_get_contents(resource_path('lang/' . $code . '.json'));
        $notify[] = 'Language';

        return apiResponse("language", "success", $notify, [
            'languages'  => $languages,
            'file'       => json_decode($jsonFile) ?? [],
            'image_path' => getFilePath('language'),
        ]);
    }

    public function policies() {
        $policies = getContent('policy_pages.element', orderById: true);
        $notify[] = 'All policies';

        return apiResponse("policy_data", "success", $notify, [
            'policies' => $policies,
        ]);
    }

    public function faq() {
        $faq      = getContent('faq.element', orderById: true);
        $notify[] = 'FAQ';
        return apiResponse("faq", "success", $notify, [
            'faq' => $faq,
        ]);
    }

    public function index(Request $request) {
        $user = $this->getAuthUser($request);

        $shorts = Short::with('user:id,username,image')
            ->approved()
            ->published()
            ->publicShort()
            ->withActiveStorage()
            ->withCount('likes', 'comments')
            ->withSum('stars', 'stars')
            ->inRandomOrder()
            ->paginate();

        $shorts->transform(fn($short) => $this->transformShort($short, $user));

        $notify[] = 'Home Data';
        return apiResponse("home_data", "success", $notify, [
            'shorts'     => $shorts,
            'coverImage' => getFilePath('coverImage'),
            'imagePath'  => getFilePath('userProfile'),
        ]);
    }

    public function recordView(Request $request) {
        $request->validate([
            'shorts_id' => 'required|exists:shorts,id',
        ]);

        $short = Short::find($request->shorts_id);

        if (!$short) {
            return apiResponse("short", "error", ['Short not found']);
        }

        $userId    = auth()->check() ? auth()->user()->id : null;
        $sessionId = Session::getId();

        $existingView = ShortView::where('shorts_id', $short->id)
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            }, function ($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->first();

        if (!$existingView) {
            $short->increment('views_count');

            $shortView             = new ShortView();
            $shortView->shorts_id  = $short->id;
            $shortView->user_id    = $userId;
            $shortView->session_id = $sessionId;
            $shortView->full_watch = 1;

            $info               = json_decode(json_encode(getIpInfo()), true);
            $shortView->country = @implode(',', $info['country']);

            $shortView->save();
        }

        return apiResponse("short_view", "success", [], [
            'success'     => true,
            'views_count' => showFormatCount($short->views_count),
        ]);
    }

    public function trackAnalytics(Request $request, $id) {
        $request->validate([
            'play_time' => 'nullable|integer|min:0',
        ]);

        $short = Short::where('id', $id)->approved()->publicShort();
        if (!$short) {
            return apiResponse("short", "error", ['Short not found']);
        }

        if ($request->has('play_time')) {
            $short->increment('total_play_time', $request->input('play_time'));
        }

        return apiResponse("track", "success", [""], [
            'success' => true,
        ]);
    }

    public function getAnalytics($id) {
        $short = Short::where('id', $id)->approved()->publicShort();
        if (!$short) {
            return apiResponse("short", "error", ['Short not found']);
        }

        return apiResponse("analytics", "success", [], [
            'total_play_time' => $short->total_play_time,
            'views_count'     => $short->views_count,
        ]);
    }

    public function share(Request $request) {
        $request->validate([
            'shorts_id' => 'required|exists:shorts,id',
            'platform'  => 'required|in:telegram,whatsapp,facebook,modal,link,messenger,pinterest,linkedin',
        ]);

        $short = Short::find($request->shorts_id);

        if (!$short) {
            return apiResponse("short", "error", ['Short not found']);
        }

        $token = getTrx();

        $shortShare              = new ShortShare();
        $shortShare->shorts_id   = $request->shorts_id;
        $shortShare->token       = $token;
        $shortShare->user_id     = auth()->check() ? auth()->user()->id : null;
        $shortShare->platform    = $request->platform;
        $shortShare->is_accessed = 0;
        $shortShare->save();

        $shareUrl = route('user.short.view', ['id' => $short->id, 'token' => $token]);

        return apiResponse('success', 'success', ['Share link generated successfully'], [
            'success'      => true,
            'share_url'    => $shareUrl,
            'shares_count' => $short->shares_count,
        ]);
    }

    public function hashtag(Request $request, $hashtag) {
        $pageTitle = '#' . $hashtag;
        $user      = $this->getAuthUser($request);

        $shorts = Short::with('user:id,username,image')
            ->approved()
            ->published()
            ->publicShort()
            ->where('description', 'like', '%' . '#' . $hashtag . '%')
            ->withActiveStorage()
            ->withCount('likes')
            ->withSum('stars', 'stars')
            ->orderBy('id', 'desc')
            ->paginate();

        $shorts->transform(fn($short) => $this->transformShort($short, $user));

        return responseManager("hashtag", $pageTitle, 'success', [
            'shorts'     => $shorts,
            'hashtag'    => $hashtag,
            'pageTitle'  => $pageTitle,
            'coverImage' => getFilePath('coverImage'),
            'imagePath'  => getFilePath('userProfile'),
        ]);
    }

    public function userProfile(Request $request, $username = null) {
        $pageTitle   = 'User Details';
        $user        = User::where('username', $username)->first();
        $userProfile = route('user.profile.details', $user->username);

        $authUser = $this->getAuthUser($request);
        $userQR   = cryptoQR($userProfile);

        if (!$user) {
            return apiResponse("details", 'error', ['user not found'], []);
        }

        if (auth()->check() && $username == auth()->user()->username) {
            return redirect()->route('user.profile.details');
        }

        $shorts = Short::where('user_id', $user->id)
            ->approved()
            ->published()
            ->publicShort()
            ->withActiveStorage()
            ->withCount('likes')
            ->withSum('stars', 'stars')
            ->orderBy('id', 'desc')
            ->paginate();

        $shorts->transform(fn($short) => $this->transformShort($short, $authUser));

        $totalLikes = Short::where('shorts.user_id', $user->id)
            ->approved()
            ->published()
            ->publicShort()
            ->withActiveStorage()
            ->join('user_reactions', 'shorts.id', '=', 'user_reactions.shorts_id')
            ->count();

        $isFollowing = false;
        if ($authUser) {
            $isFollowing = $authUser->followings()->where('followed_id', $user->id)->exists();
        }

        $user->is_following = $isFollowing;

        return responseManager("details", $pageTitle, 'success', [
            'view'           => 'Template::user.friend.details',
            'pageTitle'      => $pageTitle,
            'user'           => $user,
            'userProfile'    => $userProfile,
            'userQr'         => $userQR,
            'shorts'         => $shorts,
            'followers'      => $user->followers()->count(),
            'followings'     => $user->followings()->count(),
            'totalLikes'     => $totalLikes,
            'imagePath'      => getFilePath('userProfile'),
            'coverImagePath' => getFilePath('coverImage'),
        ]);
    }

    public function playShort($shortId) {
        $clickedShort = Short::with('user:id,username,image')
            ->approved()
            ->published()
            ->publicShort()
            ->withActiveStorage()
            ->withCount('likes')
            ->withSum('stars', 'stars')
            ->find($shortId);

        if (!$clickedShort) {
            return apiResponse("short_not_found", "error", ["Short not found"]);
        }

        $clickedShort = $this->transformShort($clickedShort);

        $otherShorts = Short::with('user:id,username,image')
            ->approved()
            ->published()
            ->publicShort()
            ->withActiveStorage()
            ->where('id', '<>', $shortId)
            ->withCount('likes')
            ->withSum('stars', 'stars')
            ->orderBy('id', 'desc')
            ->paginate();

        $otherShorts->getCollection()->transform(fn($short) => $this->transformShort($short));

        $allShorts = collect([$clickedShort])->merge($otherShorts->getCollection());
        $otherShorts->setCollection($allShorts);

        return apiResponse("play_short", "success", ["Short loaded"], [
            'shorts' => $otherShorts,
        ]);
    }

    public function getComments(Request $request) {
        $request->validate([
            'shorts_id' => 'required|exists:shorts,id',
        ]);

        $user = $this->getAuthUser($request);

        $short = Short::select('description')->find($request->shorts_id);

        $comments = Comment::with([
            'user:id,username,image',
            'short:id,description',
        ])
            ->where('shorts_id', $request->shorts_id)
            ->whereNull('parent_id')
            ->orderBy('id', 'desc')
            ->paginate();

        $comments->getCollection()->transform(function ($comment) use ($user) {
            $comment->is_liked  = $comment->isLikedBy($user?->id);
            $comment->childrens = $this->recursiveComment($comment, $user);
            unset($comment->replies);
            return $comment;
        });

        return apiResponse('comments', 'success', ['short comments'], [
            'success'   => true,
            'short'     => $short,
            'comments'  => $comments,
            'imagePath' => getFilePath('userProfile'),
        ]);
    }

    private function recursiveComment($comment, $user) {
        $commentReplies = @$comment->replies;
        $commentArray   = [];

        while ($commentReplies && $commentReplies->count() > 0) {
            foreach ($commentReplies as $commentReply) {
                $singleCommentArray             = $commentReply->toArray();
                $singleCommentArray['is_liked'] = $commentReply->isLikedBy($user?->id);
                $singleCommentArray['parent']   = [
                    'username' => $commentReply->parent->user->username,
                    'id'       => $commentReply->parent->user->id,
                ];

                array_push($commentArray, $singleCommentArray);
                $commentReplies = $commentReply->replies;
            }
        }

        return $commentArray;
    }

    /**
     * Get the authenticated user from the request bearer token.
     *
     * @param Request $request
     * @return User|null
     */
    private function getAuthUser(Request $request) {
        $token = $request->bearerToken();
        if ($token) {
            $personalToken = PersonalAccessToken::findToken($token);
            if ($personalToken && $personalToken->tokenable instanceof User) {
                return $personalToken->tokenable;
            }
        }
        return null;
    }
}
