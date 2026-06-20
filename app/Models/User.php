<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role', 'points'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin() {
        return $this->role === 'admin';
    }

    public function isPremium() {
        return $this->role === 'premium';
    }

    public function addresses() {
        return $this->hasMany(Address::class);
    }
    
    public function primaryAddress() {
        return $this->hasOne(Address::class)->where('is_primary', true);
    }

    public function cart() {
        return $this->hasOne(Cart::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function pointsTransactions() {
        return $this->hasMany(PointsTransaction::class);
    }

    public function subscriptions() {
        return $this->hasMany(UserSubscription::class);
    }
    
    public function currentSubscription() {
        return $this->hasOne(UserSubscription::class)->where('status', 'active')->where('ends_at', '>', now());
    }

    public function gameAccess() {
        return $this->hasMany(GameAccess::class);
    }
}