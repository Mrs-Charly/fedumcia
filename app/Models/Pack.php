<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price_eur',
        'tagline',
        'short_description',
        'posts_per_month',
        'review_response_hours',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_eur' => 'integer',
        'posts_per_month' => 'integer',
        'review_response_hours' => 'integer',
        'sort_order' => 'integer',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'desired_pack_id');
    }

    public function packChangeRequests()
    {
        return $this->hasMany(PackChangeRequest::class, 'requested_pack_id');
    }
}
