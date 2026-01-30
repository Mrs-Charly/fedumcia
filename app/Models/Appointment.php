<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'phone',
    'company_name',
    'scheduled_at',
    'desired_pack_id',
    'status',
    'confirmation_token',
    'consent',
    'consent_at',
    'consent_ip',
    'consent_user_agent',
    'user_id',
    'confirmed_at',
];


    protected $casts = [
        'scheduled_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'consent_at' => 'datetime',
        'consent' => 'boolean',
    ];
    
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

public function desiredPack()
{
    return $this->belongsTo(\App\Models\Pack::class, 'desired_pack_id');
}
}
