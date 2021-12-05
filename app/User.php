<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    protected $guarded = [];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function username()
    {
        return $this->email;
    }

    public function hasVerifiedEmail()
    {
        return config('settings.email_verification') ? !is_null($this->email_verified_at) : true;
    }

    public function hasVerifiedMobile()
    {
        return config('settings.mobile_verification') ? !is_null($this->mobile_verified_at) : true;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new Notifications\VerifyEmail);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new Notifications\ResetPassword($token));
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getName()
    {
        return $this->name ?: $this->mobile;
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function limits()
    {
        return $this->belongsTo(CouponLimit::class, 'model_id');
    }
}
