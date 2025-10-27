<?php

namespace App\Http\Controllers\User;

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

    public function home()
    {
        $pageTitle = 'Dashboard';
        return view('Template::user.dashboard.home', compact('pageTitle'));
    }

}
