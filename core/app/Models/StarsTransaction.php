<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarsTransaction extends Model
{
    public function short()
    {
        return $this->belongsTo(Short::class, 'short_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
