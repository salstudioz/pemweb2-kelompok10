<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model {
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'rating', 'rating_text', 'title', 'comment', 'is_approved'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    // Rating text based on rating value
    public function getRatingTextAttribute($value) {
        if ($value) return $value;
        
        return match($this->rating) {
            1 => 'Sangat Buruk',
            2 => 'Buruk', 
            3 => 'Cukup',
            4 => 'Bagus',
            5 => 'Sangat Bagus',
            default => 'Belum dinilai',
        };
    }

    // Accessor for formatted date
    public function getFormattedDateAttribute() {
        return $this->created_at->format('d M Y');
    }
}