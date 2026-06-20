<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model {
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'type', 'value', 
        'min_order', 'max_uses', 'uses_count', 'starts_at', 
        'ends_at', 'is_active'
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
    ];

    public function isValid($orderAmount = 0) {
        // Check if coupon is active
        if (!$this->is_active) return false;
        
        // Check date validity
        $now = Carbon::now();
        if ($this->starts_at && $now->lt($this->starts_at)) return false;
        if ($this->ends_at && $now->gt($this->ends_at)) return false;
        
        // Check max uses
        if ($this->max_uses && $this->uses_count >= $this->max_uses) return false;
        
        // Check minimum order amount
        if ($this->min_order && $orderAmount < $this->min_order) return false;
        
        return true;
    }

    public function applyDiscount($amount) {
        if ($this->type === 'percentage') {
            return $amount * ($this->value / 100);
        }
        
        return min($this->value, $amount);
    }

    public function incrementUses() {
        $this->increment('uses_count');
    }

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function scopeValid($query, $orderAmount = 0) {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', Carbon::now());
            })
            ->where(function($q) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>=', Carbon::now());
            })
            ->where(function($q) use ($orderAmount) {
                $q->whereNull('min_order')
                  ->orWhere('min_order', '<=', $orderAmount);
            })
            ->where(function($q) {
                $q->whereNull('max_uses')
                  ->orWhereRaw('uses_count < max_uses');
            });
    }
}