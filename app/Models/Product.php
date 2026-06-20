<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model {
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'author', 'publisher', 'isbn',
        'description', 'price', 'discount_price', 'stock', 'type',
        'cover_image', 'file_path', 'is_featured', 'is_active'
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}