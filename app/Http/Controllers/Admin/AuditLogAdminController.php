<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');           // recherche simple (action/metadata/subject)
        $action = $request->query('action'); // filtre action
        $onlyAdmin = $request->query('admin'); // 1 => actor_user_id not null

        $logs = AuditLog::query()
            ->with('actor')
            ->when($action, fn($query) => $query->where('action', $action))
            ->when($onlyAdmin === '1', fn($query) => $query->whereNotNull('actor_user_id'))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('action', 'like', "%{$q}%")
                        ->orWhere('subject_type', 'like', "%{$q}%")
                        ->orWhere('subject_id', 'like', "%{$q}%")
                        ->orWhere('metadata', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(30)
            ->withQueryString();

        // Pour un select rapide
        $actions = AuditLog::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('admin.audit_logs.index', compact('logs', 'q', 'action', 'onlyAdmin', 'actions'));
    }
}
