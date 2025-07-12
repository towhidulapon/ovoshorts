<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class StorageController extends Controller
{
    public function index()
    {
        $pageTitle = 'Storage';
        $storages  = Storage::all();
        return view('admin.storage.index', compact('pageTitle'));
    }
}
