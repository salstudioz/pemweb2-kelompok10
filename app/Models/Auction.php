<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model {
    use HasFactory;

    protected $fillable = [
        'product_id', 'starting_price', 'current_price', 'starts_at', 'ends_at', 'status', 'winner_id'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function winner() {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function bids() {
        return $this->hasMany(AuctionBid::class);
    }
}