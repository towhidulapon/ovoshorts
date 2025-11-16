<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        return $this->hasMany(Comment::class, 'parent_id')->with(['user:id,username,image']);
    }

    public function reactions()
    {
        return $this->hasMany(CommentReaction::class, 'comment_id');
    }

    public function isLikedBy($userId)
    {
        if (!$userId) {
            return false;
        }

        return $this->reactions()
            ->where('user_id', $userId)
            ->exists();
    }

}
