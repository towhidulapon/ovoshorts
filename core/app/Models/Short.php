<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Short extends Model
{
    use GlobalStatus;

    public function storage()
    {
        return $this->belongsTo(StorageSetting::class, 'storage_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(UserReaction::class, 'shorts_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'shorts_id')->whereNull('parent_id');
    }
    public function savedShorts()
    {
        return $this->hasMany(SavedShort::class, 'shorts_id');
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_shorts', 'shorts_id', 'user_id');
    }

    public function stars()
    {
        return $this->hasMany(StarsTransaction::class, 'short_id');
    }

    public function views()
    {
        return $this->hasMany(ShortView::class, 'shorts_id');
    }

    public function shares()
    {
        return $this->hasMany(ShortShare::class, 'shorts_id');
    }

    public function scopePublicShort($query)
    {
        return $query->where('is_visible', Status::EVERYONE);
    }

    public function scopePrivateShort($query)
    {
        return $query->where('is_visible', Status::ONLY_ME);
    }

    public function scopeDraftShorts($query)
    {
        return $query->where('status', Status::DRAFT);
    }

    public static function scopeWithActiveStorage($query)
    {
        return $query->where(function ($q) {
            $q->where('storage_driver', 'local')
                ->orWhereIn('storage_driver', function ($subQuery) {
                    $subQuery->select('alias')
                        ->from('storage_settings')
                        ->where('status', Status::ENABLE);
                });
        });
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', Status::SHORT_APPROVE);
    }

    public function scopePublished($query)
    {
        return $query->where('status', Status::PUBLISHED);

    }
    public function scopeUnpublished($query)
    {
        return $query->where('status', Status::UNPUBLISHED);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::DRAFT) {
                $html = '<span class="badge badge--info">' . trans('Draft') . '</span>';
            } elseif ($this->status == Status::UNPUBLISHED) {
                $html = '<span class="badge badge--warning">' . trans('Unpublished') . '</span>';
            } elseif ($this->status == Status::PUBLISHED) {
                $html = '<span class="badge badge--success">' . trans('Published') . '</span>';
            } elseif ($this->status == Status::REJECTED) {
                $html = '<span class="badge badge--danger">' . trans('Rejected') . '</span>';
            } else {
                $html = '<span class="badge badge--primary">' . trans('Scheduled') . '</span>';
            }
            return $html;
        });
    }
    public function getFileUrlAttribute()
    {
        return match ($this->storage_driver) {
            'wasabi' => getS3FileUri($this->name),
            'local'  => asset(getFilePath('shorts') . '/' . $this->name),
            default  => route('short.file', $this->name),
        };
    }
}
