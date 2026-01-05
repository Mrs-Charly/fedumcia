<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackChangeRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackChangeRequestAdminController extends Controller
{
    public function index()
    {
        $requests = PackChangeRequest::with(['user', 'requestedPack'])
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pack-requests', compact('requests'));
    }

    public function approve(Request $request, PackChangeRequest $packChangeRequest): RedirectResponse
    {
        if ($packChangeRequest->status !== 'pending') {
            return back()->with('status', 'Cette demande a déjà été traitée.');
        }

        DB::transaction(function () use ($request, $packChangeRequest) {
            // Verrouiller l'utilisateur pour éviter des collisions (2 admins, double clic, etc.)
            $user = $packChangeRequest->user()->lockForUpdate()->first();

            // Appliquer le pack demandé
            $user->pack_id = $packChangeRequest->requested_pack_id;
            $user->save();

            // Marquer la demande comme approuvée
            $packChangeRequest->status = 'approved';
            $packChangeRequest->approved_at = now();
            $packChangeRequest->rejected_at = null; // au cas où
            $packChangeRequest->processed_by = $request->user()->id;
            $packChangeRequest->save();
        });

        return back()->with('status', 'Demande approuvée : pack utilisateur mis à jour.');
    }

    public function reject(Request $request, PackChangeRequest $packChangeRequest): RedirectResponse
    {
        if ($packChangeRequest->status !== 'pending') {
            return back()->with('status', 'Cette demande a déjà été traitée.');
        }

        $packChangeRequest->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'approved_at' => null,
            'processed_by' => $request->user()->id,
        ]);

        return back()->with('status', 'Demande refusée.');
    }
}
