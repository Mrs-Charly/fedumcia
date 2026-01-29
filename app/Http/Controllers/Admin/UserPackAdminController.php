<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackChangeRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserPackAdminController extends Controller
{
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'pack_id' => 'required|exists:packs,id',
            'message' => 'nullable|string|max:1000',
        ]);

        DB::transaction(function () use ($user, $data, $request) {

            PackChangeRequest::create([
                'user_id'           => $user->id,
                'current_pack_id'   => $user->pack_id,
                'requested_pack_id' => $data['pack_id'],
                'status'            => 'approved',
                'processed_by'      => $request->user()->id,
                'approved_at'       => now(),
                'message'           => $data['message']
                    ?? 'Changement effectué manuellement par un administrateur.',
            ]);

            $user->update([
                'pack_id' => $data['pack_id'],
            ]);
        });

        return back()->with('status', 'Pack utilisateur mis à jour.');
    }
}
