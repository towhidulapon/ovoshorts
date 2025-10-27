<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortView extends Model
{
    public function short()
    {
        return $this->belongsTo(Short::class, 'shorts_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
