<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'required_points',
        'is_active',
        'demo_available',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'demo_available' => 'boolean',
        'points_required' => 'integer',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}