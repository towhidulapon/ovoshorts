<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function storage()
    {
        return $this->belongsTo(StorageSetting::class, 'storage_id', 'id');
    }
}
