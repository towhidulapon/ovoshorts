<?php
namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\StorageConfig;
use App\Models\Category;
use App\Models\Short;
use App\Traits\ShortsManager;

class ShortsUploadController extends Controller
{
    use ShortsManager;

    public function index($id = 0)
    {
        $pageTitle = 'Upload Shorts';
        $userId    = auth()->user()->id;
        $short     = null;
        if ($id) {
            $short = Short::where('user_id', $userId)->findOrFail($id);
        }
        $categories  = Category::where('status', Status::ENABLE)->get();
        $latestDraft = Short::where('user_id', $userId)->where('status', Status::DRAFT)->orderBy('id', 'desc')->first();
        return view('Template::user.short.index', compact('pageTitle', 'short', 'categories', 'latestDraft'));
    }

}
