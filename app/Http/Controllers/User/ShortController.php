<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class ShortController extends Controller
{

    private function setWasabiConfig()
    {
        $wasabi = gs('wasabi');
        if (is_string($wasabi)) {
            $wasabi = json_decode($wasabi, true);
        }
        Config::set('filesystems.disks.wasabi', [
            'driver'   => $wasabi['driver'] ?? '',
            'key'      => $wasabi['key'] ?? '',
            'secret'   => $wasabi['secret'] ?? '',
            'region'   => $wasabi['region'] ?? '',
            'bucket'   => $wasabi['bucket'] ?? '',
            'endpoint' => $wasabi['endpoint'] ?? '',
        ]);
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

        $this->setWasabiConfig();

        $file = $request->file('file');

        $extension = strtolower($file->getClientOriginalExtension());
        $type      = in_array($extension, ['mp4', 'webm', 'mov']) ? 2 : 1;

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('shorts', $filename, 'wasabi');

        $image             = new Image();
        $image->user_id    = auth()->user()->id;
        $image->image_name = $filename;
        $image->type       = $type;
        $image->save();

        return redirect()->back()->with([
            'success'  => true,
            'filename' => $filename,
        ]);

    }

    public function index()
    {
        $pageTitle = 'My Shorts';
        $user      = auth()->user();
        $this->setWasabiConfig();
        $images = Image::where('user_id', $user->id)->get();

        foreach ($images as $image) {
            $path = 'shorts/' . $image->image_name;
            if (!Storage::disk('wasabi')->exists($path)) {
                $image->delete();
            }
        }

        $images = Image::where('user_id', $user->id)->get();
        return view('Template::user.shorts.index', compact('pageTitle', 'images'));
    }

    public function viewShort($id)
    {
        $pageTitle = 'View Short';
        $user      = auth()->user();
        $image     = Image::where('id', $id)->where('user_id', $user->id)->first();
        $filename  = $image->image_name;

        $url = getS3FileUri($filename);
        return view('Template::user.shorts.view', compact('pageTitle', 'url'));
    }

    public function getFile($filename)
    {
        $this->setWasabiConfig();
        $path = 'shorts/' . $filename;

        if (!storage::disk('wasabi')->exists($path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('wasabi')->response($path);
    }

    public function deleteShort($id)
    {
        $user  = auth()->user();
        $image = Image::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $this->setWasabiConfig();
        $path = 'shorts/' . $image->image_name;

        if (Storage::disk('wasabi')->exists($path)) {
            Storage::disk('wasabi')->delete($path);
        }

        $image->delete();

        return redirect()->back()->with([
            'success' => true,
        ]);
    }
}
