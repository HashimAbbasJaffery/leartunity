<?php

namespace App\Models;

use App\Classes\Balance;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;
use Mchev\Banhammer\Traits\Bannable;

class User extends Authenticatable implements CanResetPassword, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable, Bannable, Balance, Prunable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $with = ["profile", "currency", "bans"];
    protected $fillable = [
        'name',
        'email',
        'password',
        'ip_address',
        "referred_by",
        "stripe_account_id"
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

    public function prunable() {
        return static::where("created_at", "<", now()->subDays(60))->whereNull("email_verified_at");
    }
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
        return $this->hasMany(Certificate::class, "user_id")->whereStatus(1);
    }
    public function referrals() {
        return $this->hasMany(User::class, "referred_by");
    }
    public function referrer() {
        return $this->belongsTo(User::class, "referred_by");
    }
    public function application() {
        return $this->hasOne(Application::class, "user_id");
    }
    protected $attributes = [
        "status" => 1,
        "reason" => "null"
    ];

    public function receivesBroadcastNotificationsOn(): string {
        return "notification." . $this->id;
    }
    public function currency() {
        return $this->belongsTo(Currency::class);
    }
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
