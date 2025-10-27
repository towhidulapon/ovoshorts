<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortShare extends Model
{
    public function short()
    {
        return $this->belongsTo(Short::class, 'shorts_id');
    }
}
