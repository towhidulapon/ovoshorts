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

trait ShortsManager
{
    protected $storageConfig;

    public function __construct(StorageConfig $storageConfig)
    {
        $this->storageConfig = $storageConfig;
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
            'short'         => 'required|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm,video/x-matroska|max:204800',
            'description'   => 'nullable|string|max:4000',
            'cover_image'   => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'visibility'    => 'required|in:1,2',
            'comment'       => 'nullable',
            'category_id'   => 'required|exists:categories,id',
            'post_at'       => 'required|in:1,2',
            'schedule_time' => 'nullable|required_if:post_at,2|after:now',
        ]);

        $category = Category::active()->find($request->category_id);

        if (!$category) {
            $message = 'Category not found';
            return responseManager("short", $message, 'error');
        }

        $user = auth()->user();

        $shortFile = $request->file('short');

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
        $short->allow_comments = $request->comment;
        $short->category_id    = $request->category_id;
        $short->post_at        = $request->schedule_time ?? now();
        $short->storage_id     = $storageId;
        $short->storage_driver = $storageDriver;

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

        $message = $uploadMode == Status::AUTOMATIC ? 'Short uploaded successfully' : 'Short uploaded successfully and waiting for approval';

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

}
