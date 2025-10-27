<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\StorageConfig;
use App\Traits\ShortsManager;

class ShortsUploadController extends Controller
{
    use ShortsManager;
    public function __construct(StorageConfig $storageConfig)
    {
        $this->storageConfig = $storageConfig;
    }
}
