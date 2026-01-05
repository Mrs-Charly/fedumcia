<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackChangeRequest extends Model
{
    protected $fillable = [
        'user_id', 'requested_pack_id', 'status', 'message',
        'admin_note', 'approved_at', 'rejected_at', 'processed_by'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestedPack()
    {
        return $this->belongsTo(Pack::class, 'requested_pack_id');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
