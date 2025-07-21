<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\StorageConfig;
use App\Models\Image;
use Illuminate\Http\Request;

class ShortController extends Controller
{

    protected $storageConfig;

    public function __construct(StorageConfig $storageConfig)
    {
        $this->storageConfig = $storageConfig;
    }

    public function shortUploadIndex()
    {
        $pageTitle = 'Upload Shorts';
        return view('Template::user.shorts.upload', compact('pageTitle'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:102400|mimes:jpg,jpeg,png,gif,mp4,webm,mov',
        ]);

        try {
            $disk = $this->storageConfig->configure();
        } catch (\Exception $e) {
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }

        $file = $request->file('file');

        $extension = strtolower($file->getClientOriginalExtension());
        $type      = in_array($extension, ['mp4', 'webm', 'mov']) ? 2 : 1;

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $this->storageConfig->storeFile($disk, $filename, $file);

        $image                 = new Image();
        $image->user_id        = auth()->user()->id;
        $image->image_name     = $filename;
        $image->type           = $type;
        $image->storage_driver = $disk;
        $image->save();

        $notify[] = ['success', 'Short uploaded successfully'];
        return back()->withNotify($notify);
    }

    public function index()
    {
        $pageTitle = 'My Shorts';
        $user      = auth()->user();
        $images    = Image::where('user_id', $user->id)->whereHas('storage', function ($q) {
            $q->where('status', Status::ENABLE);
        })->get();
        return view('Template::user.shorts.index', compact('pageTitle', 'images'));
    }

    public function viewShort($id)
    {
        $pageTitle = 'View Short';
        $user      = auth()->user();
        $image     = Image::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $filename  = $image->image_name;

        try {
            $this->storageConfig->configure($image->storage_driver);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Storage configuration not found'];
            return back()->withNotify($notify);
        }

        if ($image->storage_driver === 'wasabi') {

            $url = getS3FileUri($filename);
        } elseif ($image->storage_driver === 'ftp') {
            $url = route('user.short.file', $filename);
        } else {
            $notify[] = ['error', 'Unsupported storage driver'];
            return back()->withNotify($notify);
        }

        return view('Template::user.shorts.view', compact('pageTitle', 'url', 'image'));
    }

    public function getFile($filename)
    {
        $image = Image::where('image_name', $filename)->where('user_id', auth()->user()->id)->firstOrFail();
        $path  = 'shorts/' . $filename;

        try {
            $this->storageConfig->configure($image->storage_driver);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Storage configuration not found'];
            return back()->withNotify($notify);
        }

        if (!$this->storageConfig->fileExists($image->storage_driver, $path)) {
            $notify[] = ['error', 'File not found'];
            return back()->withNotify($notify);
        }

        return $this->storageConfig->getFileResponse($image->storage_driver, $path);
    }

    public function deleteShort($id)
    {
        $user  = auth()->user();
        $image = Image::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $path  = 'shorts/' . $image->image_name;

        try {
            $this->storageConfig->configure($image->storage_driver);
            $this->storageConfig->deleteFile($image->storage_driver, $path);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Storage configuration not found'];
            return back()->withNotify($notify);
        }

        $image->delete();

        $notify[] = ['success', 'Short deleted successfully'];
        return redirect()->back()->with($notify);
    }
}
