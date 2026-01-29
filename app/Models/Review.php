<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name',
        'company',
        'rating',
        'comment',
        'is_approved',
        'is_visible',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_visible' => 'boolean',
            'rating' => 'integer',
        ];
    }
}
