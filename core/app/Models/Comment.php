<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function short()
    {
        return $this->belongsTo(Short::class, 'shorts_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function reactions()
    {
        return $this->hasMany(CommentReaction::class);
    }

    public function getIsLikedAttribute()
    {
        if(!auth()->check()){
            return false;
        }
        return $this->reactions()->where('user_id', auth()->user()->id)->exists();
    }
}
