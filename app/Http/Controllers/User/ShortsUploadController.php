<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ShortsUploadController extends Controller
{
    public function index()
    {
        $pageTitle = 'Upload Shorts';
        return view('Template::user.short.index', compact('pageTitle'));
    }
}
