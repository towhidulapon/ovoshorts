<?php

// namespace App\Http\Controllers\User;

// use App\Http\Controllers\Controller;
// use App\Models\Image;
// use App\Models\StorageSetting;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Config;
// use Illuminate\Support\Facades\Storage;

// class ShortController extends Controller
// {

//     private function setWasabiConfig()
//     {
//         $wasabi = StorageSetting::where('alias', 'wasabi')->first();

//         if (!$wasabi || !isset($wasabi->parameters)) {
//             throw new \Exception("Wasabi configuration not found or invalid.");
//         }

//         $config = $wasabi->parameters;

//         Config::set('filesystems.disks.wasabi', [
//             'driver'   => $config->driver->value ?? '',
//             'key'      => $config->key->value ?? '',
//             'secret'   => $config->secret->value ?? '',
//             'region'   => $config->region->value ?? '',
//             'bucket'   => $config->bucket->value ?? '',
//             'endpoint' => $config->endpoint->value ?? '',
//         ]);
//     }

//     public function shortUploadIndex()
//     {
//         $pageTitle = 'Upload Shorts';
//         return view('Template::user.shorts.upload', compact('pageTitle'));
//     }

//     public function upload(Request $request)
//     {
//         $request->validate([
//             'file' => 'required|file|max:102400|mimes:jpg,jpeg,png,gif,mp4,webm,mov',
//         ]);

//         $this->setWasabiConfig();

//         $file = $request->file('file');

//         $extension = strtolower($file->getClientOriginalExtension());
//         $type      = in_array($extension, ['mp4', 'webm', 'mov']) ? 2 : 1;

//         $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
//         $path     = $file->storeAs('shorts', $filename, 'wasabi');

//         $image             = new Image();
//         $image->user_id    = auth()->user()->id;
//         $image->image_name = $filename;
//         $image->type       = $type;
//         $image->save();

//         return redirect()->back()->with([
//             'success'  => true,
//             'filename' => $filename,
//         ]);

//     }

//     public function index()
//     {
//         $pageTitle = 'My Shorts';
//         $user      = auth()->user();
//         $this->setWasabiConfig();
//         $images = Image::where('user_id', $user->id)->get();

//         foreach ($images as $image) {
//             $path = 'shorts/' . $image->image_name;
//             if (!Storage::disk('wasabi')->exists($path)) {
//                 $image->delete();
//             }
//         }

//         $images = Image::where('user_id', $user->id)->get();
//         return view('Template::user.shorts.index', compact('pageTitle', 'images'));
//     }

//     public function viewShort($id)
//     {
//         $pageTitle = 'View Short';
//         $user      = auth()->user();
//         $image     = Image::where('id', $id)->where('user_id', $user->id)->first();
//         $filename  = $image->image_name;

//         $url = getS3FileUri($filename);
//         return view('Template::user.shorts.view', compact('pageTitle', 'url'));
//     }

//     public function getFile($filename)
//     {
//         $this->setWasabiConfig();
//         $path = 'shorts/' . $filename;

//         if (!storage::disk('wasabi')->exists($path)) {
//             abort(404, 'File not found');
//         }

//         return Storage::disk('wasabi')->response($path);
//     }

//     public function deleteShort($id)
//     {
//         $user  = auth()->user();
//         $image = Image::where('id', $id)->where('user_id', $user->id)->firstOrFail();

//         $this->setWasabiConfig();
//         $path = 'shorts/' . $image->image_name;

//         if (Storage::disk('wasabi')->exists($path)) {
//             Storage::disk('wasabi')->delete($path);
//         }

//         $image->delete();

//         return redirect()->back()->with([
//             'success' => true,
//         ]);
//     }
// }

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\StorageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class ShortController extends Controller
{
    private function getActiveStorage()
    {
        return StorageSetting::where('status', 1)->first();
    }

    private function setWasabiConfig($config)
    {
        Config::set('filesystems.disks.wasabi', [
            'driver'                  => $config->driver->value ?? 's3',
            'key'                     => $config->key->value ?? '',
            'secret'                  => $config->secret->value ?? '',
            'region'                  => $config->region->value ?? 'us-east-1',
            'bucket'                  => $config->bucket->value ?? '',
            'endpoint'                => $config->endpoint->value ?? '',
            'use_path_style_endpoint' => true,
        ]);
    }

    private function setFtpConfig($config)
    {
        Config::set('filesystems.disks.ftp', [
            'driver'   => $config->driver->value ?? 'ftp',
            'host'     => $config->host->value ?? '',
            'username' => $config->username->value ?? '',
            'password' => $config->password->value ?? '',
            'port'     => (int) ($config->port->value),
            'root'     => $config->root->value ?? '/',
            'passive'  => true,
            'ssl'      => false,
            'timeout'  => 30,
        ]);
    }

    private function configureStorageForDriver($driver)
    {
        $storage = StorageSetting::where('alias', $driver)->first();

        if (!$storage || !isset($storage->parameters)) {
            return false;
        }

        $config = $storage->parameters;

        if ($driver === 'wasabi' && $config->driver->value === 's3') {
            $this->setWasabiConfig($config);
            return true;
        } elseif ($driver === 'ftp' && $config->driver->value === 'ftp') {
            $this->setFtpConfig($config);
            return true;
        }

        return false;
    }

    private function configureStorage()
    {
        $storage = $this->getActiveStorage();

        if (!$storage || !isset($storage->parameters)) {
            throw new \Exception("No active storage configuration found.");
        }

        $config = $storage->parameters;

        if ($config->driver->value === 's3') {
            $this->setWasabiConfig($config);
            return 'wasabi';
        } elseif ($config->driver->value === 'ftp') {
            $this->setFtpConfig($config);
            return 'ftp';
        }

        throw new \Exception("Unsupported storage driver: {$config->driver->value}");
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

        $disk = $this->configureStorage();
        $file = $request->file('file');

        $extension = strtolower($file->getClientOriginalExtension());
        $type      = in_array($extension, ['mp4', 'webm', 'mov']) ? 2 : 1;

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('shorts', $filename, $disk);

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
        $images    = Image::where('user_id', $user->id)->get();

        foreach ($images as $image) {
            $path = 'shorts/' . $image->image_name;
            if (!$this->configureStorageForDriver($image->storage_driver) || !Storage::disk($image->storage_driver)->exists($path)) {
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
        $image     = Image::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $filename  = $image->image_name;

        if (!$this->configureStorageForDriver($image->storage_driver)) {
            abort(404, 'Storage configuration not found');
        }

        if ($image->storage_driver === 'wasabi') {
            $url = getS3FileUri($filename);
        } elseif ($image->storage_driver === 'ftp') {
            $config = StorageSetting::where('alias', 'ftp')->first()->parameters;
            $host   = $config->host->value;
            $root   = $config->root->value;
            $url    = "ftp://{$host}{$root}/shorts/{$filename}";
        } else {
            abort(404, 'Unsupported storage driver');
        }

        return view('Template::user.shorts.view', compact('pageTitle', 'url'));
    }

    public function getFile($filename)
    {
        $image = Image::where('image_name', $filename)->where('user_id', auth()->user()->id)->firstOrFail();
        $path  = 'shorts/' . $filename;

        if (!$this->configureStorageForDriver($image->storage_driver) || !Storage::disk($image->storage_driver)->exists($path)) {
            abort(404, 'File not found');
        }

        return Storage::disk($image->storage_driver)->response($path);
    }

    public function deleteShort($id)
    {
        $user  = auth()->user();
        $image = Image::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $path  = 'shorts/' . $image->image_name;

        if ($this->configureStorageForDriver($image->storage_driver) && Storage::disk($image->storage_driver)->exists($path)) {
            Storage::disk($image->storage_driver)->delete($path);
        }

        $image->delete();

        return redirect()->back()->with([
            'success' => true,
        ]);
    }
}
