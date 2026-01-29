<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioProject extends Model
{
    protected $fillable = [
        'title','slug','client','category','excerpt','content',
        'cover_path','gallery_paths',
        'website_url','instagram_url','facebook_url','tiktok_url','linkedin_url',
        'is_active','sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'gallery_paths' => 'array',
        ];
    }
}
