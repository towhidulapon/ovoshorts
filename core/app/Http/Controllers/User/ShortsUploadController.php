<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Short;
use App\Models\StorageSetting;
use App\Rules\FileTypeValidate;
use App\Traits\ShortsManager;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $latestDraft = Short::where('user_id', $userId)
            ->whereNotNull('temp_path')
            ->where('status', Status::DRAFT)
            ->orderBy('id', 'desc')
            ->first();
        return view('Template::user.short.index', compact('pageTitle', 'short', 'categories', 'latestDraft'));
    }

    public function initiateUpload(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);

        $uploadId      = Str::uuid()->toString();
        $filename      = $request->filename;
        $extension     = pathinfo($filename, PATHINFO_EXTENSION);
        $username      = strtolower(auth()->user()->username);
        $finalFileName = $username . '_' . time() . '.' . $extension;
        $tempPath      = getFilePath('shortFile') . '/' . $finalFileName;

        // $short            = new Short();
        // $short->user_id   = auth()->id();
        // $short->name      = $finalFileName;
        // $short->temp_path = $tempPath;
        // $short->upload_id = $uploadId;
        // $short->status    = Status::DRAFT;
        // $short->save();

        return apiResponse("upload", 'success', ["Upload initiated successfully"], [
            'success'   => true,
            'upload_id' => $uploadId,
            'temp_path' => $tempPath,
            'filename'  => $finalFileName,
            // 'short_id'  => $short->id,
        ]);
    }

    public function uploadChunk(Request $request)
    {
        $request->validate([
            'upload_id'   => 'required',
            'chunk'       => 'required|file',
            'chunk_index' => 'required|integer',
        ]);

        $uploadId   = $request->upload_id;
        $chunk      = $request->file('chunk');
        $chunkIndex = $request->chunk_index;

        $chunkDir = getFilePath('shortChunk') . '/' . $uploadId;
        if (!file_exists($chunkDir)) {
            mkdir($chunkDir, 0755, true);
        }
        $chunkFile = $chunkDir . '/' . $chunkIndex;
        file_put_contents($chunkFile, file_get_contents($chunk));

        return apiResponse("upload", 'success', ["Chunk uploaded successfully"], [
            'success' => true,
        ]);
    }

    public function completeUpload(Request $request)
    {
        $request->validate([
            'upload_id' => 'required',
            'filename'  => 'required|string',
        ]);

        $uploadId      = $request->upload_id;
        $filename      = $request->filename;
        $extension     = pathinfo($filename, PATHINFO_EXTENSION);
        $username      = strtolower(auth()->user()->username);
        $finalFileName = $username . '_' . time() . '.' . $extension;
        $tempPath      = getFilePath('shortFile') . '/' . $finalFileName;
        $filePath      = getFilePath('shorts') . '/' . $finalFileName;

        // Merge chunks
        $chunkDir = getFilePath('shortChunk') . '/' . $uploadId;
        $chunks   = [];
        if (is_dir($chunkDir)) {
            $dir = opendir($chunkDir);
            while (($file = readdir($dir)) !== false) {
                if ($file !== '.' && $file !== '..') {
                    $chunks[] = $chunkDir . '/' . $file;
                }
            }
            sort($chunks);
            // closedir($dir);
        } else {
            return apiResponse("upload", 'error', ["No chunks found"]);
        }
        // sort($chunks);

        // $tempFile = $tempPath;
        // if (!file_exists(dirname($tempFile))) {
        //     mkdir(dirname($tempFile), 0755, true);
        // }

        // $file = fopen($tempFile, 'wb');
        // foreach ($chunks as $chunk) {
        //     fwrite($file, file_get_contents($chunk));
        // }
        // fclose($file);

        // DB::beginTransaction();

        // try {
        //     $driver = $this->storageConfig->configure();
        // } catch (\Exception $e) {
        //     $driver = 'local';
        // }

        // $storage = StorageSetting::where('alias', $driver)->first();
        // $short   = Short::where('upload_id', $uploadId)->first();

        // try {
        //     if (!$storage) {
        //         $success = $this->storageConfig->storeLocalFile($finalFileName, $tempFile);
        //         if (!$success) {
        //             return apiResponse("upload", 'error', ["Failed to save file to local storage"]);
        //         }
        //         $storageId     = 0;
        //         $storageDriver = 'local';
        //     } else {
        //         if (file_exists($tempFile)) {
        //             $uploadStatus = $this->storageConfig->storeFile($driver, $finalFileName, new UploadedFile($tempFile, $finalFileName));
        //             if (!$uploadStatus) {
        //                 throw new \Exception("Failed to upload file to storage");
        //             }
        //         } else {
        //             return apiResponse("upload", 'error', ["File not found"]);
        //         }
        //         $storageId     = $storage->id;
        //         $storageDriver = $driver;
        //     }

        //     if ($short) {
        //         $short->name           = $finalFileName;
        //         $short->storage_id     = $storageId;
        //         $short->storage_driver = $storageDriver;
        //         $short->temp_path      = $tempPath;
        //         $short->save();
        //     }

        //     DB::commit();
        // } catch (\Exception $e) {

        //     DB::rollBack();

        //     if (file_Exists($tempFile)) {
        //         unlink($tempFile);
        //     }

        //     if (is_dir($chunkDir)) {
        //         $files = glob($chunkDir . '/*');
        //         foreach ($files as $file) {
        //             if (is_file($file)) {
        //                 unlink($file);
        //             }
        //         }
        //         rmdir($chunkDir);
        //     }

        //     if ($short) {
        //         $short->delete();
        //     }

        //     return apiResponse("upload", 'error', ["Upload Failed: " . $e->getMessage()]);
        // }

        // return apiResponse("upload", 'success', ["Upload Completed"], [
        //     'video_path' => $filePath,
        //     'short_id'   => $short->id,
        //     'success'    => true,
        // ]);

        if (!file_exists(dirname($tempPath))) {
            mkdir(dirname($tempPath), 0755, true);
        }

        $output = fopen($tempPath, 'wb');
        foreach ($chunks as $chunk) {
            fwrite($output, file_get_contents($chunk));
        }
        fclose($output);

        DB::beginTransaction();
        try {
            $driver = $this->storageConfig->configure();
        } catch (\Exception $e) {
            $driver = 'local';
        }

        $storage = StorageSetting::where('alias', $driver)->first();

        try {
            if (!$storage || $driver === 'local') {
                $success = $this->storageConfig->storeLocalFile($finalFileName, $tempPath);
                if (!$success) {
                    throw new \Exception("Failed to save file locally");
                }
                $storageId     = 0;
                $storageDriver = 'local';
            } else {
                $uploaded = $this->storageConfig->storeFile(
                    $driver,
                    $finalFileName,
                    new UploadedFile($tempPath, $finalFileName)
                );
                if (!$uploaded) {
                    throw new \Exception("Failed to upload to cloud storage");
                }
                $storageId     = $storage->id;
                $storageDriver = $driver;
            }

            // CREATE DRAFT ONLY HERE — AFTER FILE IS FULLY UPLOADED
            $short                 = new Short();
            $short->user_id        = auth()->id();
            $short->name           = $finalFileName;
            $short->storage_id     = $storageId;
            $short->storage_driver = $storageDriver;
            $short->temp_path      = $filePath; // Path for final video
            $short->upload_id      = $uploadId; // Optional: keep for cleanup
            $short->status         = Status::DRAFT;
            $short->save();

            DB::commit();

            // Clean up chunks
            foreach ($chunks as $chunk) {
                @unlink($chunk);
            }
            @rmdir($chunkDir);

            return apiResponse("upload", 'success', ["Upload Completed"], [
                'video_path' => $filePath,
                'short_id'   => $short->id,
                'success'    => true,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Cleanup on failure
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            foreach ($chunks as $chunk) {
                @unlink($chunk);
            }
            @rmdir($chunkDir);

            return apiResponse("upload", 'error', ["Upload Failed: " . $e->getMessage()]);
        }

    }

    public function store(Request $request, $id = 0)
    {
        $isUpdate = $id != 0;

        $baseRules = [
            'description'      => 'nullable|string|max:4000',
            'cover_image'      => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'cover_image_data' => 'nullable|string',
            'visibility'       => 'required|in:1,2',
            'comment'          => 'nullable|boolean',
            'category_id'      => 'required',
            'post_at'          => 'required|in:1,2',
            'schedule_time'    => 'nullable|required_if:post_at,2|after:now',
        ];

        if (!$isUpdate) {
            $baseRules['short_id'] = 'required|exists:shorts,id';
        }

        $rules = $baseRules;

        $messages = [
            'description.max'           => 'Description cannot exceed 4000 characters.',
            'cover_image.image'         => 'Cover image must be a valid image file.',
            'cover_image.mimes'         => 'Cover image must be of type: jpg, jpeg, png.',
            'category_id.required'      => 'Please select a category.',
            'category_id.exists'        => 'Selected category does not exist.',
            'schedule_time.required_if' => 'Schedule time is required when post type is scheduled.',
            'schedule_time.after'       => 'Schedule time must be in the future.',
            'short_id.required'         => 'Short ID is required.',
            'short_id.exists'           => 'Invalid short ID provided.',
        ];

        $request->validate($rules, $messages);

        $category = Category::active()->find($request->category_id);

        if (!$category) {
            $message = 'Category not found';
            return responseManager("short", $message, 'error');
        }

        if (!$isUpdate && !$request->hasFile('cover_image') && !$request->filled('cover_image_data')) {
            $message = 'A cover image is required';
            return responseManager("short", $message, 'error');
        }

        if ($isUpdate) {
            $short = Short::where('user_id', auth()->id())->find($id);
            if (!$short) {
                $notify[] = ['error', 'Short not found'];
                return back()->withNotify($notify);
            }
            if ($short->user_id != auth()->id()) {
                $message = 'Unauthorized action';
                return responseManager("short", $message, 'error');
            }

            $short->description    = $request->description;
            $short->is_visible     = $request->visibility;
            $short->allow_comments = $request->comment;
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

            $message = 'Short updated successfully';
            return responseManager("short", $message, 'success');
        }

        $short = Short::where('user_id', auth()->id())->where('id', $request->short_id)->where('status', Status::DRAFT)->first();
        if (!$short) {
            $message = 'Draft not found';
            return responseManager("short", $message, 'error');
        }

        $short->description    = $request->description;
        $short->is_visible     = $request->visibility;
        $short->allow_comments = $request->comment ?? 0;
        $short->category_id    = $request->category_id;
        $short->post_at        = $request->schedule_time ?? now();

        if ($request->hasFile('cover_image')) {
            try {
                $short->cover_image = fileUploader($request->cover_image, getFilePath('coverImage'));
            } catch (\Exception $exp) {
                $message = 'Couldn\'t upload your image';
                return responseManager("short", $message, 'error');
            }
        } elseif ($request->filled('cover_image_data')) {
            try {
                $dataUrl   = $request->input('cover_image_data');
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $dataUrl));
                $filename  = 'cover_' . time() . '.png';
                $path      = getFilePath('coverImage') . '/' . $filename;
                file_put_contents($path, $imageData);
                $short->cover_image = $filename;
            } catch (\Exception $exp) {
                $message = 'Couldn\'t process the cover image';
                return responseManager("short", $message, 'error');
            }
        }

        $uploadMode = gs('short_approval');

        if ($uploadMode == Status::MANUAL) {
            $short->is_approved = Status::SHORT_PENDING;
            if ($short->post_at >= now()) {
                $short->status = Status::SCHEDULE;
            } else {
                $short->status = Status::UNPUBLISHED;
            }
        } else {
            $short->is_approved = Status::SHORT_APPROVE;
            if ($short->post_at >= now()) {
                $short->status = Status::SCHEDULE;
            } else {
                $short->status = Status::PUBLISHED;
            }
        }

        $short->save();

        if ($short->name) {
            $videoPath = getFilePath('shortFile') . '/' . $short->name;
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        }

        if ($short->temp_path && file_exists($short->temp_path)) {
            unlink($short->temp_path);
        }

        if ($short->upload_id) {
            $chunkDir = getFilePath('shortChunk') . '/' . $short->upload_id;
            if (is_dir($chunkDir)) {
                $files = glob($chunkDir . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                rmdir($chunkDir);
            }
        }

        $message = $uploadMode == Status::AUTOMATIC ? 'Short uploaded successfully' : 'Short uploaded successfully and waiting for approval';

        return responseManager("short_upload", $message, "success");
    }
}
