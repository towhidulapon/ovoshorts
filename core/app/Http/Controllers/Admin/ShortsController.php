<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\StorageConfig;
use App\Models\Short;
use Illuminate\Http\Request;

class ShortsController extends Controller
{
    protected $storageConfig;

    public function __construct(StorageConfig $storageConfig)
    {
        $this->storageConfig = $storageConfig;
    }

    public function index()
    {
        return $this->getShorts('All Shorts');
    }

    public function unpublished()
    {
        return $this->getShorts('Unpublished Shorts', Status::UNPUBLISHED);
    }

    public function scheduledShorts()
    {
        $pageTitle = 'Scheduled Shorts';
        $shorts = Short::with('user')
            ->where('status', Status::SCHEDULE)
            ->searchable(['name'])
            ->filter(['id'])
            ->dateFilter()
            ->orderBy('id', getOrderBy())
            ->paginate(getPaginate());

        return view('admin.short.index', compact('pageTitle', 'shorts'));

    }

    public function published()
    {
        return $this->getShorts('Published Shorts', Status::PUBLISHED);
    }

    public function rejected()
    {
        return $this->getShorts('Rejected Shorts', Status::REJECTED);
    }

    private function getShorts($pageTitle, $status = null)
    {
        $shorts = Short::with('user')
            ->when($status !== null, fn($q) => $q->where('status', $status))
            ->where('status', '!=', Status::DRAFT)
            ->approved()
            ->searchable(['name'])
            ->filter(['id'])
            ->dateFilter()
            ->orderBy('id', getOrderBy())
            ->paginate(getPaginate());

        return view('admin.short.index', compact('pageTitle', 'shorts'));
    }

    private function shortsQuery($status = null, $visibility = null)
    {
        $query = Short::with('user')
            ->approved()
            ->searchable(['name'])
            ->filter(['id'])
            ->dateFilter()
            ->orderBy('id', getOrderBy());

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($visibility !== null) {
            $query->where('is_visible', $visibility);
        }

        return $query->paginate(getPaginate());
    }

    public function pendingShorts()
    {
        $pageTitle = 'Pending Shorts';
        $shorts    = Short::where('is_approved', Status::SHORT_PENDING)->where('status', Status::PUBLISHED)->orderBy('id', 'desc')->paginate(getPaginate());

        return view('admin.short.index', compact('pageTitle', 'shorts'));
    }

    public function publicShorts()
    {
        $pageTitle = 'Public Shorts';
        $shorts    = $this->shortsQuery(Status::PUBLISHED, Status::EVERYONE);

        return view('admin.short.index', compact('pageTitle', 'shorts'));
    }

    public function privateShorts()
    {
        $pageTitle = 'Private Shorts';
        $shorts    = $this->shortsQuery(Status::PUBLISHED, Status::ONLY_ME);

        return view('admin.short.index', compact('pageTitle', 'shorts'));
    }

    public function draftShorts()
    {
        $pageTitle = 'Draft Shorts';
        $shorts = Short::with('user')
            ->where('status', Status::DRAFT)
            ->searchable(['name'])
            ->filter(['id'])
            ->dateFilter()
            ->orderBy('id', getOrderBy())
            ->paginate(getPaginate());
        return view('admin.short.index', compact('pageTitle', 'shorts'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'details' => 'required|string|max:255',
        ]);
        $short              = Short::findOrFail($id);
        $short->is_approved = Status::SHORT_APPROVE;

        if ($short->post_at >= now()) {
            $short->status = Status::SCHEDULE;
        } else {
            $short->status = Status::PUBLISHED;
        }

        $short->admin_feedback = $request->details;
        $short->save();

        notify($short->user, 'SHORT_APPROVE', [
            'short'          => $short->name,
            'approved_at'    => $short->updated_at,
            'admin_feedback' => $short->admin_feedback,
        ]);

        $notify[] = ['success', 'Short has been approved successfully'];
        return back()->withNotify($notify);
    }

    public function reject(Request $request, $id)
    {
        $short                 = Short::findOrFail($id);
        $short->is_approved    = Status::SHORT_REJECT;
        $short->status         = Status::REJECTED;
        $short->admin_feedback = $request->details;
        $short->save();

        $path = 'shorts/' . $short->name;

        try {
            $this->storageConfig->configure($short->storage_driver);
            $this->storageConfig->deleteFile($short->storage_driver, $path);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Storage configuration not found'];
            return back()->withNotify($notify);
        }

        notify($short->user, 'SHORT_REJECT', [
            'short'          => $short->name,
            'rejected_at'    => $short->updated_at,
            'admin_feedback' => $short->admin_feedback,
        ]);

        $notify[] = ['success', 'Short has been rejected successfully'];
        return to_route('admin.short.unpublished')->withNotify($notify);
    }

    public function details($id)
    {
        $pageTitle = 'Short Detail';
        $short     = Short::with(['user', 'storage', 'category'])->findOrFail($id);
        $filename  = $short->name;

        try {
            $this->storageConfig->configure($short->storage_driver);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Storage configuration not found'];
            return back()->withNotify($notify);
        }

        $url = match ($short->storage_driver) {
            'wasabi' => getS3FileUri($filename),
            'local'  => asset(getFilePath('shorts') . '/' . $filename),
            default  => route('short.file', $filename),
        };

        return view('admin.short.detail', compact('short', 'pageTitle', 'url'));
    }

    public function status($id)
    {
        return Short::changeStatus($id);
    }
}
