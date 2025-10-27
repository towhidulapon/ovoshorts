<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReaction extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'shorts_owner_id', 'id');
    }

    public function short()
    {
        return $this->belongsTo(Short::class, 'shorts_id', 'id');
    }
}
