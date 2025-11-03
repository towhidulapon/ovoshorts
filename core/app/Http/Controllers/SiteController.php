<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Lib\StorageConfig;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Page;
use App\Models\Short;
use App\Models\ShortShare;
use App\Models\ShortView;
use App\Models\User;
use App\Models\UserReaction;
use App\Traits\StarManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{

    use StarManager;
    protected $storageConfig;

    public function __construct(StorageConfig $storageConfig)
    {
        $this->storageConfig = $storageConfig;
    }

    public function index()
    {
        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }
        $pageTitle   = 'Home';
        $sections    = Page::where('tempname', activeTemplate())->where('slug', '/')->first();
        $seoContents = $sections->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;

        $users     = User::active()->where('id', '!=', auth()->id())->searchable(['username'])->get();
        $following = auth()->check() ? auth()->user()->followings->pluck('id')->toArray() : [];

        $shortsQuery = Short::with('user', 'storage', 'comments.user', 'comments.replies.user', 'savedShorts')
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
            ->withCount('likes')
            ->withSum('stars', 'stars')
            ->orderBy('id', 'desc');

        $shorts = $shortsQuery->paginate(getPaginate(5));

        $hasMorePages = $shorts->hasMorePages();

        $shorts->getCollection()->transform(function ($short) {
            return prepareShortData($short);
        });

        return view('Template::home', compact('pageTitle', 'sections', 'following', 'shorts', 'seoContents', 'seoImage', 'hasMorePages'));
    }

    public function loadMoreShorts(Request $request)
    {
        $following = auth()->check() ? auth()->user()->followings->pluck('id')->toArray() : [];
        $shorts    = Short::with('user', 'comments.user', 'comments.replies.user')
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
            ->withCount('likes')
            ->withSum('stars', 'stars')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(5), ['*'], 'page', $request->page);

        $html = '';

        $shorts->getCollection()->transform(function ($short) {
            return prepareShortData($short);
        });

        foreach ($shorts as $short) {
            $html .= view('Template::user.short.view.video_item', ['short' => $short, 'following' => $following])->render();
        }

        return response()->json([
            'success' => true,
            'data'    => [
                'html'    => $html,
                'hasMore' => $shorts->hasMorePages(),
            ],
        ]);
    }

    public function recordView(Request $request)
    {
        $request->validate([
            'shorts_id' => 'required|exists:shorts,id',
        ]);

        $short     = Short::findOrFail($request->shorts_id);
        $userId    = auth()->check() ? auth()->user()->id : null;
        $sessionId = Session::getId();

        $viewInterval = gs('view_interval');

        $existingView = ShortView::where('shorts_id', $short->id)
            ->when($userId, function ($query) use ($userId) {
                return $query->where('user_id', $userId);
            }, function ($query) use ($sessionId) {
                return $query->where('session_id', $sessionId);
            })
            ->where('created_at', '>=', Carbon::now()->subSeconds($viewInterval))
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

        return response()->json([
            'success'     => true,
            'views_count' => showFormatCount($short->views_count),
        ]);
    }

    public function trackAnalytics(Request $request, $id)
    {
        $request->validate([
            'play_time' => 'nullable|integer|min:0',
        ]);

        $short = Short::where('id', $id)->approved()->firstOrFail();

        if ($request->has('play_time')) {
            $short->increment('total_play_time', $request->input('play_time'));
        }

        return response()->json(['success' => true]);
    }

    public function getAnalytics($id)
    {
        $short = Short::where('id', $id)->approved()->firstOrFail();
        return response()->json([
            'total_play_time' => $short->total_play_time,
            'views_count'     => $short->views_count,
        ]);
    }

    public function search(Request $request)
    {
        $pageTitle = 'Search User';
        $search    = $request->search;

        //TODO:: ***** jodi user er only 1ta video thake only me hishebe & server disable thakle tahole search er moddhe oi user show korena

        $shorts = Short::with('user', 'storage', 'comments.user', 'comments.replies.user', 'savedShorts')
            ->searchable(['user:username', 'description'])
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
            ->get()
            ->map(function ($short) {
                return prepareShortData($short);
            });

        $view = 'Template::user.short.search';

        return responseManager("userSearch", $pageTitle, 'success', [
            'view'      => $view,
            'shorts'    => $shorts,
            'search'    => $search,
            'pageTitle' => $pageTitle,
        ]);
    }

    public function hashtag($hashtag)
    {
        $pageTitle = 'Search';

        $shorts = Short::with('user', 'storage', 'comments.user', 'comments.replies.user', 'savedShorts')
            ->approved()
            ->published()
            ->publicShort()
            ->where('description', 'like', '%' . '#' . $hashtag . '%')
            ->where(function ($query) {
                $query->where('storage_driver', 'local')
                    ->orWhereIn('storage_driver', function ($subQuery) {
                        $subQuery->select('alias')
                            ->from('storage_settings')
                            ->where('status', Status::ENABLE);
                    });
            })
            ->orderBy('id', 'desc')
            ->get();

        $userReactions = [];

        if (auth()->check()) {
            $userId   = auth()->id();
            $shortIds = $shorts->pluck('id');

            $userReactions = UserReaction::whereIn('shorts_id', $shortIds)
                ->where('user_id', $userId)
                ->pluck('shorts_id')
                ->toArray();
        }

        $shorts = $shorts->map(function ($short) use ($userReactions) {
            return prepareShortData($short, $userReactions);
        });

        $view = 'Template::user.short.hashtag';

        return responseManager("hashtag", $pageTitle, 'success', [
            'view'      => $view,
            'shorts'    => $shorts,
            'hashtag'   => $hashtag,
            'pageTitle' => $pageTitle,
        ]);
    }

    public function pages($slug)
    {
        $page        = Page::where('tempname', activeTemplate())->where('slug', $slug)->firstOrFail();
        $pageTitle   = $page->name;
        $sections    = $page->secs;
        $seoContents = $page->seo_content;
        $seoImage    = @$seoContents->image ? getImage(getFilePath('seo') . '/' . @$seoContents->image, getFileSize('seo')) : null;
        return view('Template::pages', compact('pageTitle', 'sections', 'seoContents', 'seoImage'));
    }

    public function policyPages($slug)
    {
        $policy      = Frontend::where('slug', $slug)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle   = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::policy', compact('policy', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) {
            $lang = 'en';
        }

        session()->put('lang', $lang);
        return back();
    }

    public function blogs()
    {
        $pageTitle   = 'Blogs';
        $blogs       = Frontend::where('data_keys', 'blog.element')->latest()->paginate(getPaginate(21));
        $latest      = Frontend::latest()->where('data_keys', 'blog.element')->limit(10)->get();
        $sections    = Page::where('tempname', activeTemplate())->where('slug', 'blog')->first();
        $seoContents = $sections->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::blogs', compact('pageTitle', 'blogs', 'latest', 'sections', 'seoContents', 'seoImage'));
    }

    public function blogDetails($slug)
    {
        $blog        = Frontend::where('slug', $slug)->where('data_keys', 'blog.element')->firstOrFail();
        $pageTitle   = $blog->data_values->title;
        $seoContents = $blog->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::blog_details', compact('blog', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookieContent = Frontend::where('data_keys', 'cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE, 404);
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize  = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        // header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);

        ob_start();
        imagejpeg($image);
        $imageData = ob_get_clean();

        imagedestroy($image);

        return response($imageData)->header('Content-Type', 'image/jpeg');
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('Template::maintenance', compact('pageTitle', 'maintenance'));
    }

    public function getFile($filename)
    {
        $short = Short::where('name', $filename)->firstOrFail();
        $path  = 'shorts/' . $filename;

        try {
            $this->storageConfig->configure($short->storage_driver);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Storage configuration not found'];
            return back()->withNotify($notify);
        }

        return $this->storageConfig->getFileResponse($short->storage_driver, $path);
    }

    public function share(Request $request)
    {
        $request->validate([
            'shorts_id' => 'required|exists:shorts,id',
            'platform'  => 'required|in:telegram,whatsapp,facebook,modal,link,messenger,pinterest,linkedin',
        ]);

        $short = Short::find($request->shorts_id);
        $token = getTrx();

        if(!$short) {
            return apiResponse("short", "error", ['Short not found']);
        }

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

    public function viewShort($id, $token = null)
    {
        $pageTitle = 'View Short';
        $short     = Short::with('user', 'comments.user', 'comments.replies.user', 'savedShorts')
            ->where('id', $id)
            ->approved()
            ->published()
            ->where(function ($query) {
                $query->where('storage_driver', 'local')
                    ->orWhereIn('storage_driver', function ($subQuery) {
                        $subQuery->select('alias')
                            ->from('storage_settings')
                            ->where('status', Status::ENABLE);
                    });
            })
            ->withCount('likes')
            ->withSum('stars', 'stars')
            ->firstOrFail();

        $short = prepareShortData($short);

        if ($token) {
            $share = ShortShare::where('token', $token)
                ->where('shorts_id', $id)
                ->where('is_accessed', 0)
                ->first();

            if ($share) {
                $share->is_accessed = 1;
                $share->save();

                $short->increment('shares_count');
                $short->save();
            }
        }

        return view('Template::user.short.view.single_post', compact('short', 'pageTitle'));
    }

    public function getShorts(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $userShorts = Short::where('user_id', $request->user_id)
            ->where('id', '!=', $request->exclude_short_id)
            ->approved()
            ->published()
            ->where(function ($query) {
                $query->where('storage_driver', 'local')
                    ->orWhereIn('storage_driver', function ($subQuery) {
                        $subQuery->select('alias')
                            ->from('storage_settings')
                            ->where('status', Status::ENABLE);
                    });
            })
            ->withCount('likes')
            ->withSum('stars', 'stars')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(), ['*'], 'page', $request->input('page', 1));

        $userShorts->getCollection()->transform(function ($short) {
            return prepareShortData($short);
        });

        $html = '';
        foreach ($userShorts as $short) {
            $html .= view('Template::user.short.view.short_item', compact('short'))->render();
        }

        return response()->json([
            'data' => [
                'success'   => true,
                'html'      => $html,
                'has_more'  => $userShorts->hasMorePages(),
                'next_page' => $userShorts->currentPage() + 1,
            ],
        ]);
    }

    public function getComments(Request $request)
    {
        $request->validate([
            'shorts_id' => 'required|exists:shorts,id',
        ]);

        $userId = auth()->check() ? auth()->user()->id : null;
        $page   = $request->input('page', 1);

        $comments = Comment::with(['user', 'replies.user'])
            ->where('shorts_id', $request->shorts_id)
            ->whereNull('parent_id')
            ->orderBy('id', 'desc')
            ->paginate(getPaginate(8), ['*'], 'page', $page);

        $html = '';

        foreach ($comments as $comment) {
            $html .= view('Template::user.short.view.comment.comment_item', ['comment' => $comment])->render();
        }

        return apiResponse('comments', 'success', [], [
            'success'   => true,
            'comments'  => $comments->items(),
            'html'      => $html,
            'has_more'  => $comments->hasMorePages(),
            'next_page' => $comments->currentPage() + 1,
        ]);
    }

    public function explore($id = 0)
    {
        $pageTitle = 'Explore Shorts';

        $query = Short::query()
            ->with('user', 'likes')
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
            ->orderBy('id', 'desc');

        //TODO :: explore e user er nijer videos show korbe?

        // if (auth()->check()) {
        //     $query->where('user_id', '!=', auth()->user()->id);
        // }

        if ($id) {
            $query->where('category_id', $id);
        }

        if (request()->ajax()) {
            $id     = request()->get('id', $id);
            $page   = request()->get('page', 1);
            $shorts = $query->paginate(getPaginate(), ['*'], 'page', $page);

            $shorts->getCollection()->transform(function ($short) {
                return prepareShortData($short);
            });

            return response()->json([
                'html'         => view('Template::user.short.explore_shorts', compact('shorts'))->render(),
                'hasMorePages' => $shorts->hasMorePages(),
            ]);
        }

        $shorts = $query->paginate(18);

        $shorts->getCollection()->transform(function ($short) {
            return prepareShortData($short);
        });

        $categories = Category::where('status', Status::ENABLE)
            ->orderBy('name', 'asc')
            ->get();

        return view('Template::user.short.explore', compact('pageTitle', 'categories', 'shorts', 'id'));
    }

    public function exploreShorts($id = 0)
    {
        $query = Short::query()
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

        if ($id) {
            $query->where('category_id', $id);
        }

        $shorts = $query->get();

        return view('Template::user.short.explore_shorts', compact('shorts'))->render();
    }

    public function userProfile($username = null)
    {
        $pageTitle = 'User Details';
        $follower  = User::where('username', $username)->first();
        if (!$follower) {
            return apiResponse("details", 'error', ['user not found'], []);
        }
        if (auth()->check() && $username == auth()->user()->username) {
            return redirect()->route('user.profile.details');
        }
        $following = auth()->check() ? auth()->user()->followings->pluck('id')->toArray() : [];

        $shortsQuery = Short::with('likes', 'user')
            ->where('user_id', $follower->id)
            ->published()
            ->publicShort()
            ->where(function ($query) {
                $query->where('storage_driver', 'local')
                    ->orWhereIn('storage_driver', function ($subQuery) {
                        $subQuery->select('alias')
                            ->from('storage_settings')
                            ->where('status', Status::ENABLE);
                    });
            });
        $shorts = $shortsQuery->orderBy('id', 'desc')->paginate(getPaginate(), ['*'], 'page', 1);

        $shorts->getCollection()->transform(function ($short) {
            return prepareShortData($short);
        });

        $totalLikes = $shorts->sum(function ($short) {
            return $short->likes->count();
        });

        return responseManager("details", $pageTitle, 'success', [
            'view'       => 'Template::user.friend.details',
            'pageTitle'  => $pageTitle,
            'follower'   => $follower,
            'following'  => $following,
            'shorts'     => $shorts,
            'totalLikes' => $totalLikes,
            'imagePath'  => getFilePath('userProfile'),
        ]);
    }

    public function userProfileShorts(Request $request, $username = null)
    {
        $follower = User::where('username', $username)->first();
        if (!$follower) {
            return apiResponse("details", 'error', ['user not found'], []);
        }

        $sort        = $request->input('sort', 'latest');
        $page        = $request->input('page', 2);
        $shortsQuery = Short::with('likes')
            ->where('user_id', $follower->id)
            ->published()
            ->publicShort()
            ->where(function ($query) {
                $query->where('storage_driver', 'local')
                    ->orWhereIn('storage_driver', function ($subQuery) {
                        $subQuery->select('alias')
                            ->from('storage_settings')
                            ->where('status', Status::ENABLE);
                    });
            });

        switch ($sort) {
            case 'popular':
                $shortsQuery->withCount('likes')->orderBy('likes_count', 'desc');
                break;
            case 'oldest':
                $shortsQuery->orderBy('created_at', 'asc');
                break;
            case 'latest':
            default:
                $shortsQuery->orderBy('created_at', 'desc');
                break;
        }

        $shorts = $shortsQuery->paginate(getPaginate(), ['*'], 'page', $page);
        $html   = view('Template::user.friend.shorts', compact('shorts'))->render();

        return apiResponse("user_shorts", 'success', ['shorts'], [
            'data'         => $html,
            'hasMorePages' => $shorts->hasMorePages(),
        ]);
    }
}
