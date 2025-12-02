<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $casts = [
        'is_used' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUser(): Attribute
    {
        return new Attribute(
            get: function () {
                if ($this->user_id) {
                    $user = $this->user;
                } else {
                    $user = null;
                }
                return $user;
            },
        );
    }

    public function getUserType()
    {
        if ($this->user_id) {
            return 'USER';
        }

        return null;
    }
}
