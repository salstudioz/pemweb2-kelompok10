<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $fillable = [
        'user_id', 'order_number', 'total_amount', 'shipping_cost',
        'grand_total', 'status', 'payment_status', 'shipping_address', 
        'payment_method', 'address', 'notes'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function payment() {
        return $this->hasOne(Payment::class);
    }

    // Accessor for final_amount (compatibility)
    public function getFinalAmountAttribute() {
        return $this->grand_total;
    }
}