<?php

namespace App\Traits;

use App\Constants\Status;
use App\Lib\StorageConfig;
use App\Models\Category;
use App\Models\Short;
use App\Models\StorageSetting;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use FFMpeg\FFProbe;

trait ShortsManager
{
    protected $storageConfig;

    public function __construct(StorageConfig $storageConfig)
    {
        $this->storageConfig = $storageConfig;
    }

    public function initiateUpload(Request $request)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);

        $uploadId  = Str::uuid()->toString();
        $filename  = $request->filename;
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $username      = strtolower(auth()->user()->username);
        $finalFileName = $username . '_' . time() . '.' . $extension;
        $tempPath      = getFilePath('shortFile') . '/' . $finalFileName;

        $short            = new Short();
        $short->user_id   = auth()->id();
        $short->name      = $finalFileName;
        $short->temp_path = $tempPath;
        $short->upload_id = $uploadId;
        $short->status    = Status::DRAFT;
        $short->save();

        return apiResponse("upload", 'success', ["Upload initiated successfully"], [
            'success'   => true,
            'upload_id' => $uploadId,
            'temp_path' => $tempPath,
            'short_id'  => $short->id,
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
            closedir($dir);
        }
        sort($chunks);

        $tempFile = $tempPath;
        if (!file_exists(dirname($tempFile))) {
            mkdir(dirname($tempFile), 0755, true);
        }

        $file = fopen($tempFile, 'wb');
        foreach ($chunks as $chunk) {
            fwrite($file, file_get_contents($chunk));
        }
        fclose($file);

        try {
            $driver = $this->storageConfig->configure();
        } catch (\Exception $e) {
            $driver = 'local';
        }

        $storage = StorageSetting::where('alias', $driver)->first();
        $short   = Short::where('upload_id', $uploadId)->first();

        if (!$storage) {
            $success = $this->storageConfig->storeLocalFile($finalFileName, $tempFile);
            if (!$success) {
                return apiResponse("upload", 'error', ["Failed to save file to local storage"]);
            }
            $storageId     = 0;
            $storageDriver = 'local';
        } else {
            if (file_exists($tempFile)) {
                $this->storageConfig->storeFile($driver, $finalFileName, new UploadedFile($tempFile, $finalFileName));
            } else {
                return apiResponse("upload", 'error', ["File not found"]);
            }
            $storageId     = $storage->id;
            $storageDriver = $driver;
        }

        if ($short) {
            $short->name           = $finalFileName;
            $short->storage_id     = $storageId;
            $short->storage_driver = $storageDriver;
            $short->temp_path      = $tempPath;
            $short->save();
        }

        return apiResponse("upload", 'success', ["Upload Completed"], [
            'video_path' => $filePath,
            'short_id'   => $short->id,
            'success'    => true,
        ]);
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
            $short->allow_comments = $request->comment ?? 0;
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
                // $short->post_at = $request->schedule_time;
                $short->status = Status::SCHEDULE;
            } else {
                // $short->post_at = now();
                $short->status = Status::UNPUBLISHED;
            }
        } else {
            $short->is_approved = Status::SHORT_APPROVE;
            if ($short->post_at >= now()) {
                // $short->post_at = $request->schedule_time;
                $short->status = Status::SCHEDULE;
            } else {
                // $short->post_at = now();
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

        // $message = $short->is_approved == Status::SHORT_APPROVE ? 'Short uploaded successfully' : 'Short uploaded successfully and waiting for approval';
        $message = $uploadMode == Status::AUTOMATIC ? 'Short uploaded successfully' : 'Short uploaded successfully and waiting for approval';

        return responseManager("short_upload", $message, "success");
    }

    public function getCategories()
    {
        $categories = Category::active()
            ->orderBy('id', 'desc')
            ->get();

        return apiResponse("categories", 'success', ["Categories fetched successfully"], [
            'categories' => $categories,
        ]);
    }

    public function uploadShort(Request $request)
    {
        $request->validate([
            'short'       => 'required|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm,video/x-matroska|max:204800',
            'description' => 'nullable|string|max:4000',
            'cover_image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'visibility'  => 'required|in:1,2',
            'comment'     => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $category = Category::active()->find($request->category_id);

        if (!$category) {
            $message = 'Category not found';
            return responseManager("short", $message, 'error');
        }

        $user = auth()->user();

        $shortFile = $request->file('short');

        if (!$this->isValidVideoDuration($shortFile, 120)) {
            return apiResponse("upload", 'error', ["Video length exceeds the maximum allowed duration of 2 minutes"]);
        }

        $extension = strtolower($shortFile->getClientOriginalExtension());
        $filename  = strtolower($user->username) . '_' . time() . '.' . $extension;

        try {
            $driver = $this->storageConfig->configure();
        } catch (\Exception $e) {
            $driver = 'local';
        }

        $storage = StorageSetting::where('alias', $driver)->first();

        if (!$storage) {
            $videoPath = getFilePath('shorts') . '/' . $filename;
            $success   = $this->storageConfig->storeLocalFile($filename, $shortFile);
            if (!$success) {
                return apiResponse("upload", 'error', ["Failed to save file to local storage"]);
            }
            $storageId     = 0;
            $storageDriver = 'local';
        } else {
            $videoPath = 'shorts/' . $filename;
            try {
                $this->storageConfig->storeFile($driver, $filename, new UploadedFile($shortFile, $filename));
            } catch (\Exception $e) {
                return apiResponse("upload", 'error', ["Failed to upload file to storage"]);
            }
            $storageId     = $storage->id;
            $storageDriver = $driver;
        }

        $short              = new Short();
        $short->user_id     = $user->id;
        $short->name        = $filename;
        $short->description = $request->description;

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

        $short->is_visible     = $request->visibility;
        $short->allow_comments = $request->comment ?? 0;
        $short->category_id    = $request->category_id;
        $short->post_at        = now();
        $short->storage_id     = $storageId;
        $short->storage_driver = $storageDriver;

        $uploadMode = gs('short_approval');

        if ($uploadMode == Status::SHORT_PENDING) {
            $short->is_approved = Status::SHORT_PENDING;
            $short->post_at     = $request->schedule_time;
            $short->status      = Status::UNPUBLISHED;
        } else {
            $short->is_approved = Status::SHORT_APPROVE;
            if ($request->post_at == Status::LATER) {
                $short->post_at = $request->schedule_time;
                $short->status  = Status::SCHEDULE;
            } else {
                $short->post_at = now();
                $short->status  = Status::PUBLISHED;
            }
        }
        $message = $short->is_approved == Status::PUBLISHED ? 'Short uploaded successfully' : 'Short uploaded successfully and waiting for approval';
        $short->save();

        return apiResponse("short_upload", "success", [$message], [
            'short_id'       => $short->id,
            'video_path'     => $videoPath,
            'storage_driver' => $storageDriver,
        ]);
    }

    public function createDraft(Request $request)
    {
        $request->validate([
            'short_id'         => 'required|exists:shorts,id',
            'cover_image_data' => 'required|string',
        ]);

        $short = Short::where('user_id', auth()->id())->where('id', $request->short_id)->where('status', Status::DRAFT)->first();
        if (!$short) {
            return apiResponse("upload", 'success', ["Draft not found"], [
                'success' => false,
            ]);
        }

        try {
            $dataUrl   = $request->input('cover_image_data');
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $dataUrl));
            $filename  = 'cover_' . time() . '.png';
            $path      = getFilePath('coverImage') . '/' . $filename;
            file_put_contents($path, $imageData);
            $short->cover_image = $filename;
            $short->save();
            return apiResponse("upload", 'success', ["Cover image uploaded successfully"], [
                'filename' => $filename,
                'success'  => true,
            ]);
        } catch (\Exception $exp) {
            return apiResponse("upload", 'error', ["Couldn't process the cover image"], [
                'success' => false,
            ]);
        }
    }

    public function deleteDraft($id)
    {
        $short = Short::where('user_id', auth()->id())->where('status', Status::DRAFT)->findOrFail($id);

        if ($short->name) {

            $path = 'shorts/' . $short->name;

            $this->storageConfig->configure($short->storage_driver);
            $this->storageConfig->deleteFile($short->storage_driver, $path);

            $finalLocalPath = getFilePath('shorts') . '/' . $short->name;
            if (file_exists($finalLocalPath)) {
                unlink($finalLocalPath);
            }

            $tempFilePath = getFilePath('shortFile') . '/' . $short->name;
            if (file_exists($tempFilePath)) {
                unlink($tempFilePath);
            }
        }

        if ($short->temp_path && file_exists($short->temp_path)) {
            unlink($short->temp_path);
        }

        if ($short->name) {
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

        if ($short->cover_image) {
            $coverImagePath = getFilePath('coverImage') . '/' . $short->cover_image;
            if (file_exists($coverImagePath)) {
                @unlink($coverImagePath);
            }
        }

        $short->delete();

        $redirect = 'user.short.upload.index';
        $message  = 'Draft deleted, select another video';

        return responseManager("delete_draft", $message, 'success', [
            'redirect' => $redirect,
            'message'  => $message,
            'status'   => 'success',
        ]);
    }

    private function isValidVideoDuration(UploadedFile $file, $maxSeconds = 120)
    {
        if (!$file->isValid()) {
            return false;
        }

        try {
            $ffprobe  = FFProbe::create();
            $duration = $ffprobe
                ->format($file->getRealPath())
                ->get('duration');

            return round($duration) <= $maxSeconds;
        } catch (\Exception $e) {
            return false;
        }
    }

}
