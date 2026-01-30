<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuditLogger
{
    public static function log(
        string $action,
        ?Model $subject = null,
        array $metadata = [],
        ?Request $request = null
    ): void {
        $request ??= request();

        AuditLog::create([
            'actor_user_id' => auth()->id(),
            'action'        => $action,
            'subject_type'  => $subject ? get_class($subject) : null,
            'subject_id'    => $subject?->getKey(),
            'ip'            => $request?->ip(),
            'user_agent'    => $request ? substr((string) $request->userAgent(), 0, 512) : null,
            'metadata'      => $metadata ?: null,
        ]);
    }
}
