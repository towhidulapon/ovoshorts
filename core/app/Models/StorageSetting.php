<?php

namespace App\Models;

use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Model;

class StorageSetting extends Model
{
    use GlobalStatus;

    protected $casts = [
        'parameters' => 'object',
    ];
}
