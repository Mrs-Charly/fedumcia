<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\AuditLogger;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $users = User::query()
            ->with('pack')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function create()
    {
        $packs = Pack::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.users.create', compact('packs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'             => ['required', 'string', 'min:10'],
            'is_admin'             => ['nullable', 'boolean'],
            'pack_id'              => ['nullable', 'exists:packs,id'],
            'address_line1'        => ['nullable', 'string', 'max:255'],
            'address_postal_code'  => ['nullable', 'string', 'max:20'],
            'address_city'         => ['nullable', 'string', 'max:120'],
        ]);

        User::create([
            'name'                 => $data['name'],
            'email'                => $data['email'],
            'password'             => Hash::make($data['password']),
            'is_admin'             => (bool)($data['is_admin'] ?? false),
            'pack_id'              => $data['pack_id'] ?? null,
            'email_verified_at'    => now(),
            'address_line1'        => $data['address_line1'] ?? null,
            'address_postal_code'  => $data['address_postal_code'] ?? null,
            'address_city'         => $data['address_city'] ?? null,
        ]);

        return redirect()->route('admin.users.index')->with('status', 'Utilisateur créé.');
    }

    public function show(User $user)
{
    $user->load(['pack', 'packChangeRequests' => function ($q) {
        $q->latest();
    }]);

    $packs = Pack::query()->where('is_active', true)->orderBy('sort_order')->get();

    return view('admin.users.show', compact('user', 'packs'));
}


    public function edit(User $user)
    {
        $packs = Pack::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.users.edit', compact('user', 'packs'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'is_admin'             => ['nullable', 'boolean'],
            'pack_id'              => ['nullable', 'exists:packs,id'],
            'password'             => ['nullable', 'string', 'min:10'],
            'address_line1'        => ['nullable', 'string', 'max:255'],
            'address_postal_code'  => ['nullable', 'string', 'max:20'],
            'address_city'         => ['nullable', 'string', 'max:120'],
        ]);

        $payload = [
            'name'                 => $data['name'],
            'email'                => $data['email'],
            'is_admin'             => (bool)($data['is_admin'] ?? false),
            'pack_id'              => $data['pack_id'] ?? null,
            'address_line1'        => $data['address_line1'] ?? null,
            'address_postal_code'  => $data['address_postal_code'] ?? null,
            'address_city'         => $data['address_city'] ?? null,
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        $user->update($payload);

        return back()->with('status', 'Utilisateur mis à jour.');
    }

    public function updatePack(Request $request, User $user)
{
    $data = $request->validate([
        'pack_id' => ['nullable', 'exists:packs,id'],
    ]);

    $oldPackId = $user->pack_id;
    $newPackId = $data['pack_id'] ?? null;

    if ($oldPackId === $newPackId) {
        return back()->with('status', 'Aucun changement.');
    }

    $user->update(['pack_id' => $newPackId]);

    \App\Models\PackChangeRequest::create([
        'user_id'           => $user->id,
        'current_pack_id'   => $oldPackId,
        'requested_pack_id' => $newPackId,
        'status'            => 'approved',
        'message'           => 'Changement appliqué directement par un administrateur.',
        'processed_by'      => $request->user()->id,
        'approved_at'       => now(),
        'source'            => 'admin_direct',
    ]);

    return back()->with('status', 'Pack utilisateur mis à jour (historique enregistré).');

    AuditLogger::log('user.pack_changed', $user, [
    'pack_id' => $user->pack_id,
]);
}


    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('status', 'Impossible de supprimer votre propre compte admin.');
        }

        if ($user->is_admin) {
            return back()->with('status', 'Suppression refusée : compte administrateur.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('status', 'Utilisateur supprimé.');
    }
}
