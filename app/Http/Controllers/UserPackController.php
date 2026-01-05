<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\PackChangeRequest;
use Illuminate\Http\Request;

class UserPackController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();

        $packs = Pack::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $pendingRequest = PackChangeRequest::query()
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        return view('account.pack', compact('user', 'packs', 'pendingRequest'));
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'requested_pack_id' => ['nullable', 'exists:packs,id'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        // empêcher plusieurs demandes en attente
        $alreadyPending = PackChangeRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->exists();

        if ($alreadyPending) {
            return back()->withErrors([
                'requested_pack_id' => "Une demande est déjà en attente. Attendez la validation Fedumcia."
            ]);
        }

        PackChangeRequest::create([
            'user_id' => $user->id,
            'requested_pack_id' => $data['requested_pack_id'] ?? null,
            'status' => 'pending',
            'message' => $data['message'] ?? null,
        ]);

        return redirect()->route('pack.edit')->with('status', 'Demande envoyée. Nous reviendrons vers vous rapidement.');
    }
}
