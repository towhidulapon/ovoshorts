<?php

namespace App\Traits;

use App\Constants\Status;
use App\Lib\StorageConfig;
use App\Models\Category;
use App\Models\Short;
use App\Models\ShortShare;
use App\Models\ShortView;
use Illuminate\Http\Request;

trait DashboardManager
{
    protected $storageConfig;

    public function __construct(StorageConfig $storageConfig)
    {
        $this->storageConfig = $storageConfig;
    }
    public function analytics()
    {
        $pageTitle    = 'Analytics';
        $countryViews = ShortView::whereHas('short', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->select('country')
            ->selectRaw('count(*) as total')
            ->groupBy('country')
            ->get();

        $totalViews = $countryViews->sum('total');

        $trafficSources = $countryViews->map(function ($row) use ($totalViews) {
            return [
                'country'    => $row->country,
                'percentage' => $totalViews > 0 ? round(($row->total / $totalViews) * 100, 2) : 0,
            ];
        });

        $platformShares = ShortShare::whereHas('short', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->select('platform')
            ->selectRaw('count(*) as total')
            ->groupBy('platform')
            ->get();

        $totalShares = $platformShares->sum('total');

        $platformShares = $platformShares->map(function ($row) use ($totalShares) {
            return [
                'platform'   => $row->platform,
                'percentage' => $totalShares > 0 ? round(($row->total / $totalShares) * 100, 2) : 0,
            ];
        });

        $view = 'Template::user.dashboard.analytics.overview';

        return responseManager("analytics", $pageTitle, 'success', [
            'view'           => $view,
            'pageTitle'      => $pageTitle,
            'trafficSources' => $trafficSources,
            'platformShares' => $platformShares,
        ]);
    }

    public function analyticsContent(Request $request)
    {
        $pageTitle = "Content";
        $userId    = auth()->user()->id;

        $sort = $request->query('sort', 'views');

        $query = Short::where('user_id', $userId)
            ->withCount([
                'likes',
                'views as views_last_7_days' => function ($query) {
                    $query->where('created_at', '>=', now()->subDays(7));
                },
                'likes as likes_last_7_days' => function ($query) {
                    $query->where('created_at', '>=', now()->subDays(7));
                },
            ]);

        if ($sort === 'likes') {
            $query->orderBy('likes_count', 'desc');
        } else {
            $query->orderBy('views_count', 'desc');
        }

        $shorts = $query->take(5)->get();

        $mostViews = $shorts->map(function ($short) {
            return [
                'cover_image'       => getImage(getFilePath('coverImage') . '/' . $short->cover_image, getFileSize('coverImage')),
                'description'       => strLimit($short->description, 20),
                'views_last_7_days' => showFormatCount($short->views_last_7_days),
                'views_count'       => showFormatCount($short->views_count),
                'likes_last_7_days' => showFormatCount($short->likes_last_7_days),
                'likes_count'       => showFormatCount($short->likes_count),
                'created_at'        => diffForHumans($short->created_at),
                'analytics_url'     => route('user.dashboard.analytics.post', $short->name),
            ];
        });

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'shorts'  => $mostViews,
            ]);
        }

        if (isApiRequest()) {
            return apiResponse('analytics', 'success', [], [
                'success'    => true,
                'most_views' => $mostViews,
            ]);
        }

        $view = 'Template::user.dashboard.analytics.content';

        return responseManager("analytics content", $pageTitle, 'success', [
            'view'      => $view,
            'pageTitle' => $pageTitle,
            'shorts'    => $shorts,
        ]);
    }

    public function analyticsViewers()
    {
        $pageTitle    = "Viewers";
        $totalViewers = ShortView::whereHas('short', function ($q) {
            $q->where('user_id', auth()->id());
        })->count();

        $newViewers = ShortView::whereHas('short', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->distinct('user_id')
            ->count('user_id');

        $returningViewers = ShortView::whereHas('short', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->distinct('user_id')
            ->count('user_id');

        $newViewersPercentage       = $totalViewers > 0 ? round(($newViewers / $totalViewers) * 100, 2) : 0;
        $returningViewersPercentage = $totalViewers > 0 ? round(($returningViewers / $totalViewers) * 100, 2) : 0;

        $view = 'Template::user.dashboard.analytics.viewers';

        return responseManager("analytics viewers", $pageTitle, 'success', [
            'view'                       => $view,
            'pageTitle'                  => $pageTitle,
            'totalViewers'               => $totalViewers,
            'newViewers'                 => $newViewers,
            'newViewersPercentage'       => $newViewersPercentage,
            'returningViewersPercentage' => $returningViewersPercentage,
        ]);
    }

    public function post(Request $request)
    {
        $pageTitle = "Post";
        $sort      = request()->query('sort', 'id');
        $order     = request()->query('order', 'desc');

        $query = Short::withCount('likes', 'comments')->searchable(['description'])->where('user_id', auth()->user()->id);

        if ($sort == 'privacy') {
            $shorts = $query->orderBy('is_visible', $order == 'asc' ? 'asc' : 'desc');
        } elseif ($sort == 'likes') {
            $shorts = $query->orderBy('likes_count', $order == 'asc' ? 'asc' : 'desc');
        } elseif ($sort == 'comments') {
            $shorts = $query->orderBy('comments_count', $order == 'asc' ? 'asc' : 'desc');
        } elseif ($sort == 'views') {
            $shorts = $query->orderBy('views_count', $order == 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('is_pinned', 'desc')->orderBy('id', 'desc');
        }

        $shorts = $query->whereNot('status', Status::DRAFT)->paginate(getPaginate());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data'    => view('Template::user.dashboard.post_table', compact('shorts'))->render(),
            ]);
        }

        return responseManager("post", $pageTitle, 'success', [
            'view'      => 'Template::user.dashboard.post',
            'pageTitle' => $pageTitle,
            'shorts'    => $shorts,
        ]);
    }

    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:shorts,id',
            'privacy' => 'required|in:1,2',
        ]);
        $short = Short::where('user_id', auth()->user()->id)
            ->where('id', $request->post_id)
            ->firstOrFail();
        $short->is_visible = $request->privacy;
        $short->save();

        $privacyOptions = [
            1 => __('Everyone'),
            2 => __('Only Me'),
        ];

        return apiResponse('privacy', 'success', [], [
            'success'           => true,
            'new_privacy_label' => $privacyOptions[$short->is_visible],
            'new_privacy_value' => $short->is_visible,
        ]);
    }

    public function postAnalytics($id)
    {
        $pageTitle = "Analytics";
        $user      = auth()->user();
        $short     = Short::where('user_id', $user->id)->where('id', $id)->withCount('likes', 'comments', 'savedShorts')->firstOrFail();

        $countryViews = ShortView::where('shorts_id', $short->id)->whereHas('short', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->select('country')
            ->selectRaw('count(*) as total')
            ->groupBy('country')
            ->get();

        $totalViews = $countryViews->sum('total');

        $trafficSources = $countryViews->map(function ($row) use ($totalViews) {
            return [
                'country'    => $row->country,
                'percentage' => $totalViews > 0 ? round(($row->total / $totalViews) * 100, 2) : 0,
            ];
        });

        $platformShares = ShortShare::where('shorts_id', $short->id)->whereHas('short', function ($q) {
            $q->where('user_id', auth()->id());
        })
            ->select('platform')
            ->selectRaw('count(*) as total')
            ->groupBy('platform')
            ->get();

        $totalShares = $platformShares->sum('total');

        $platformShares = $platformShares->map(function ($row) use ($totalShares) {
            return [
                'platform'   => $row->platform,
                'percentage' => $totalShares > 0 ? round(($row->total / $totalShares) * 100, 2) : 0,
            ];
        });

        return responseManager("post", $pageTitle, 'success', [
            'view'           => 'Template::user.dashboard.analytics.post',
            'pageTitle'      => $pageTitle,
            'short'          => $short,
            'trafficSources' => $trafficSources,
            'platformShares' => $platformShares,
        ]);
    }

    public function pinShort($id)
    {
        $user             = auth()->user();
        $short            = Short::where('user_id', $user->id)->findOrFail($id);
        $short->is_pinned = $short->is_pinned == Status::YES ? Status::NO : Status::YES;
        $short->save();

        $shorts = Short::withCount('likes', 'comments')
            ->where('user_id', $user->id)
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        if (isApiRequest()) {
            return apiResponse('post', 'success', [], [
                'success' => true,
                'message' => $short->is_pinned == 0 ? 'Short unpinned successfully' : 'Short pinned successfully',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $short->is_pinned == 0 ? 'Short unpinned successfully' : 'Short pinned successfully',
            'view'    => view('Template::user.dashboard.post_table', compact('shorts'))->render(),
        ]);
    }

    public function deleteShort($id)
    {
        $user  = auth()->user();
        $short = Short::where('user_id', $user->id)->find($id);

        if (!$short) {
            return response()->json([
                'success' => false,
                'message' => 'Short not found',
            ]);
        }

        $path = 'shorts/' . $short->name;

        try {
            if ($short->storage_driver === 'local') {
                $localFilePath = getFilePath('shorts') . '/' . $short->name;
                if (file_exists($localFilePath)) {
                    unlink($localFilePath);
                }
            } else {
                $this->storageConfig->configure($short->storage_driver);
                $this->storageConfig->deleteFile($short->storage_driver, $path);
            }
        } catch (\Exception $e) {
            $notify[] = ['error', 'Storage configuration not found'];
            return back()->withNotify($notify);
        }

        try {
            $coverImagePath = getFilePath('coverImage') . '/' . $short->cover_image;
            if (file_exists($coverImagePath)) {
                unlink($coverImagePath);
            }
        } catch (\Exception $e) {
            $notify[] = ['error', 'Storage configuration not found'];
            return back()->withNotify($notify);
        }

        $short->delete();

        return responseManager('delete', 'short deleted', 'success', [
            'success' => true,
            'message' => 'Short deleted successfully',
        ]);
    }

    public function analyticsData()
    {
        $pageTitle = 'Analytics Data';
        $user      = auth()->user();

        $shorts = Short::where('user_id', $user->id)->get();

        $lastShort      = Short::where('user_id', $user->id)->orderBy('views_count', 'desc')->first();
        $lastShortViews = $lastShort ? $lastShort->views_count : 0;

        $totalShortViews = $shorts->sum('views_count');

        $newFollowers = $user->followers()
            ->wherePivot('created_at', '>=', now()->subDays(7))
            ->count();

        $estimatedRewards = $user->stars * gs('star_price');

        return apiResponse('analytics', 'success', [$pageTitle], [
            'totalShortViews'  => $totalShortViews,
            'totalShortLikes'  => $user->totalLikes,
            'newFollowers'     => $newFollowers,
            'lastShortViews'   => $lastShortViews,
            'userBalance'      => showAmount($user->balance),
            'estimatedRewards' => showAmount($estimatedRewards),
        ]);
    }

    public function editShort($id)
    {
        $user  = auth()->user();
        $short = Short::where('user_id', $user->id)->find($id);

        $categories = Category::active()
            ->orderBy('id', 'desc')
            ->get();

        $pageTitle = 'Edit Short';
        $view      = 'Template::user.short.edit';

        return responseManager('Edit Short', $pageTitle, 'success', [
            'view'       => $view,
            'short'      => $short,
            'categories' => $categories,
            'pageTitle'  => $pageTitle,
        ]);
    }

    public function updateShort(Request $request, $id)
    {
        $request->validate([
            'description'    => 'nullable|string|max:4000',
            'is_visible'     => 'required|in:1,2',
            'allow_comments' => 'required|in:1,0',
            'category_id'    => 'required|exists:categories,id',
        ]);

        $short = Short::where('user_id', auth()->user()->id)->find($id);

        if (!$short) {
            $message = 'Short not found';
            return apiResponse("short", 'error', [$message]);
        }

        $category = Category::active()->find($request->category_id);

        if (!$category) {
            $message = 'Category not found';
            return apiResponse("short", 'error', [$message]);
        }

        $short->description    = $request->description;
        $short->is_visible     = $request->is_visible;
        $short->allow_comments = $request->allow_comments;
        $short->category_id    = $request->category_id;

        if ($request->hasFile('cover_image')) {
            try {
                if ($short->cover_image && file_exists(getFilePath('coverImage') . '/' . $short->cover_image)) {
                    unlink(getFilePath('coverImage') . '/' . $short->cover_image);
                }
                $short->cover_image = fileUploader($request->cover_image, getFilePath('coverImage'));
            } catch (\Exception $exp) {
                $message = 'Couldn\'t upload your image';
                return responseManager("short", $message, 'error');
            }
        }

        $short->save();

        return apiResponse("short", 'success', ['Short updated successfully']);
    }
}
