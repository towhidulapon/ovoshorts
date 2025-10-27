<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lib\StorageConfig;
use App\Traits\DashboardManager;

class DashboardController extends Controller
{
    use DashboardManager;

    public function __construct(StorageConfig $storageConfig)
    {
        $this->storageConfig = $storageConfig;
    }
}
