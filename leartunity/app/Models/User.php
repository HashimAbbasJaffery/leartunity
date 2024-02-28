<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    protected function courses() {
        return $this->hasMany(Course::class, "author_id");
    }
    public function purchases() {
        return $this->hasMany(Purchase::class, "user_id");
    }
    public function profile(){
        return $this->hasOne(Profile::class);
    }
    public function follows_to() {
        return $this->belongsToMany(User::class, "follow_user", "follower_id", "followee_id");
    }
    public function follows() {
        return $this->belongsToMany(User::class, "follow_user", "followee_id", "follower_id");
    }
    public function achievements() {
        return $this->belongsToMany(Achievement::class, "achievement_user");
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function certificates() {
        return $this->hasMany(Certificate::class, "certificate_id")->whereStatus(1);
    }
}
