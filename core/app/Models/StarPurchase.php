<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StarPurchase extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function star()
    {
        return $this->belongsTo(Star::class);
    }
}
