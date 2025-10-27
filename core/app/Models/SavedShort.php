<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedShort extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function short()
    {
        return $this->belongsTo(Short::class, 'shorts_id');
    }
}
