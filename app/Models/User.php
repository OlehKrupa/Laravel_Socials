<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'facebook_id',
        'twitter_id',
        'is_subscribed',
        'is_admin',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function scopeAdmins(Builder $query)
    {
        return $query->where('is_admin', true);
    }

    public function scopeSubscribed(Builder $query)
    {
        return $query->where('is_subscribed', true)->where('is_admin', false);
    }

    public function scopeCreatedWithinLast5Days(Builder $query)
    {
        return $query->whereDate('created_at', '>', Carbon::now()->subDays(5));
    }
}
