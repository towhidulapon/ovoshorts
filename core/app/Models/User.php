<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\UserNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use UserNotify, HasApiTokens;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'ver_code',
        'balance',
        'kyc_data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'kyc_data'          => 'object',
        'verification_data' => 'object',
        'ver_code_send_at'  => 'datetime',
        'last_seen'         => 'datetime',
    ];

    /**
     * specified column for export with column manipulation
     *
     * @var array
     */
    public function exportColumns(): array
    {
        return [
            'firstname',
            'lastname',
            'username',
            'email',
            'mobile',
            "country_name",
            "created_at" => [
                'name'     => "Joined At",
                'callback' => function ($item) {
                    return showDateTime($item->created_at, lang: 'en');
                },
            ],
            "balance"    => [
                'callback' => function ($item) {
                    return showAmount($item->balance);
                },
            ],
        ];
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'from_id');
    }

    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'user_id', 'followed_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'user_id')->withTimestamps();
    }

    public function reactions()
    {
        return $this->hasMany(UserReaction::class, 'shorts_owner_id', 'id');
    }

    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function shorts()
    {
        return $this->hasMany(Short::class);
    }

    public function likes()
    {
        return $this->hasMany(UserReaction::class);
    }

    public function hasLiked($short)
    {
        return $this->likes()->where('short_id', $short->id)->exists();
    }

    public function savedShorts()
    {
        return $this->hasMany(SavedShort::class);
    }

    public function favoriteShorts()
    {
        return $this->belongsToMany(Short::class, 'saved_shorts', 'user_id', 'shorts_id');
    }

    public function starPurchases()
    {
        return $this->hasMany(StarPurchase::class);
    }

    public function isVerified()
    {
        return $this->is_verified;
    }

    public function isOnline()
    {
        return $this->last_seen && $this->last_seen->gt(now()->subMinutes(5));
    }

    public function updateLastSeen()
    {
        $this->last_seen = now();
        $this->save();
    }

    public function imageSrc(): Attribute
    {
        return new Attribute(
            get: fn() => getImage(getFilePath('userProfile') . '/' . $this->image, getFilePath('userProfile'), isAvatar: true),
        );
    }

    public function fullNameShortForm(): Attribute
    {
        return new Attribute(
            get: fn() => strtoupper(substr($this->firstname, 0, 1)) . strtoupper(substr($this->lastname, 0, 1)),
        );
    }

    public function mobileNumber(): Attribute
    {
        return new Attribute(
            get: fn() => $this->dial_code . $this->mobile,
        );
    }

    public function totalLikes(): Attribute
    {
        return new Attribute(
            get: fn() => UserReaction::where('shorts_owner_id', $this->id)->count(),
        );
    }

    public function totalComments(): Attribute
    {
        return new Attribute(
            get: fn() => Comment::whereIn('shorts_id', $this->shorts()->pluck('id'))
                ->whereNull('parent_id')
                ->count(),
        );
    }

    public function totalShares(): Attribute
    {
        return new Attribute(
            get: fn() => Short::where('user_id', $this->id)->sum('shares_count'),
        );
    }

    public function totalStars(): Attribute
    {
        return new Attribute(

            get: fn() => $this->starPurchases()->where('status', Status::PAYMENT_SUCCESS)
                ->with('star')
                ->get()
                ->sum(fn($purchase) => $purchase->star->stars ?? 0),
        );
    }

    public function getTotalViewsAttribute()
    {
        return $this->shorts()->sum('views_count');
    }

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED);
    }

    public function scopeVerified($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED)->where('is_verified', Status::VERIFIED);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeKycUnverified($query)
    {
        return $query->where('kv', Status::KYC_UNVERIFIED);
    }

    public function scopeKycPending($query)
    {
        return $query->where('kv', Status::KYC_PENDING);
    }

    public function scopeVerificationPending($query)
    {
        return $query->where('is_verified', Status::VERIFICATION_PENDING);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }

    public function scopeWithBalance($query)
    {
        return $query->where('balance', '>', 0);
    }

    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }
}
