<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShortsUploadController extends Controller
{
    public function index()
    {
        $pageTitle = 'Upload Shorts';
        return view('Template::user.short.index', compact('pageTitle'));
    }

    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'extension' => ['required', 'in:mp4,mov,wmv,flv,avi,mkv'],
            'fileName'  => 'required|string',
            'index'     => 'required|integer',
            'uniqueId'  => 'required|string',
            'chunk'     => 'required|file',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        try {
            $file     = $request->file('chunk');
            $fileName = $request->input('fileName');
            $index    = $request->input('index');
            $uniqueId = $request->input('uniqueId');
            $tempDir  = storage_path("app/temp/{$uniqueId}");
            if (!is_dir($tempDir)) {
                mkdir($tempDir, 0755, true);
            }
            $chunkPath = "{$tempDir}/{$fileName}.part{$index}";
            if (file_exists($chunkPath)) {
                unlink($chunkPath);
            }
            $file->move($tempDir, "{$fileName}.part{$index}");
            return response()->json(['status' => 'success', 'message' => 'Chunk uploaded successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function assembleFile(Request $request)
    {
        $uniqueId  = $request->input('uniqueId');
        $fileName  = $request->input('fileName');
        $extension = $request->input('extension');
        $tempDir   = storage_path("app/temp/{$uniqueId}");
        $finalPath = storage_path("app/videos/{$fileName}");
        $out       = fopen($finalPath, 'wb');
        $i         = 0;
        while (true) {
            $chunkPath = "{$tempDir}/{$fileName}.part{$i}";
            if (!file_exists($chunkPath)) {
                break;
            }

            $in = fopen($chunkPath, 'rb');
            while ($buff = fread($in, 4096)) {
                fwrite($out, $buff);
            }
            fclose($in);
            unlink($chunkPath);
            $i++;
        }
        fclose($out);
        @rmdir($tempDir);
        $url = asset('storage/videos/' . $fileName);
        return response()->json(['status' => 'success', 'video_url' => $url]);
    }
}
