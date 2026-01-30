<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\AuditLogger;

class PackAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $active = $request->query('active');

        $packs = Pack::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%")
                        ->orWhere('tagline', 'like', "%{$q}%");
                });
            })
            ->when($active !== null && $active !== '', function ($query) use ($active) {
                $query->where('is_active', (bool) ((int) $active));
            })
            ->orderBy('sort_order')
            ->paginate(20)
            ->withQueryString();

        return view('admin.packs.index', compact('packs', 'q', 'active'));
    }

    public function create()
    {
        return view('admin.packs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'slug'                  => ['nullable', 'string', 'max:255', 'unique:packs,slug'],
            'price_eur'             => ['required', 'integer', 'min:0'],
            'tagline'               => ['nullable', 'string', 'max:255'],
            'short_description'     => ['nullable', 'string', 'max:1000'],
            'posts_per_month'       => ['nullable', 'integer', 'min:0'],
            'review_response_hours' => ['nullable', 'integer', 'min:0'],
            'is_active'             => ['required', 'boolean'],
            'sort_order'            => ['nullable', 'integer', 'min:0'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $data['sort_order'] = $data['sort_order'] ?? 0;

        Pack::create($data);

        return redirect()->route('admin.packs.index')->with('status', 'Pack créé.');
    }

    public function edit(Pack $pack)
    {
        return view('admin.packs.edit', compact('pack'));
    }

    public function update(Request $request, Pack $pack)
    {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'slug'                  => ['required', 'string', 'max:255', 'unique:packs,slug,' . $pack->id],
            'price_eur'             => ['required', 'integer', 'min:0'],
            'tagline'               => ['nullable', 'string', 'max:255'],
            'short_description'     => ['nullable', 'string', 'max:1000'],
            'posts_per_month'       => ['nullable', 'integer', 'min:0'],
            'review_response_hours' => ['nullable', 'integer', 'min:0'],
            'is_active'             => ['required', 'boolean'],
            'sort_order'            => ['nullable', 'integer', 'min:0'],
        ]);

        $pack->update($data);

        return back()->with('status', 'Pack mis à jour.');
    }

    public function destroy(Pack $pack)
{
    $usedByUsers = $pack->users()->exists();
    $usedByAppointments = $pack->appointments()->exists();
    $usedByRequests = $pack->packChangeRequests()->exists();

    if ($usedByUsers || $usedByAppointments || $usedByRequests) {
        return back()->with('status', 'Suppression impossible : ce pack est utilisé (users / rdv / demandes).');
    }

    $pack->delete();

    return redirect()->route('admin.packs.index')->with('status', 'Pack supprimé.');
}


    public function toggleActive(Request $request, Pack $pack)
{
    // Si on veut désactiver
    if ($pack->is_active) {
        $usedByUsers = $pack->users()->exists();
        $hasPendingRequests = $pack->packChangeRequests()->where('status', 'pending')->exists();

        if ($usedByUsers || $hasPendingRequests) {
            return back()->with('status', 'Désactivation refusée : ce pack est utilisé (utilisateurs ou demandes en attente).');
        }
        AuditLogger::log('pack.toggled', $pack, [
    'is_active' => (bool) $pack->is_active,
]);
    }

    $pack->update(['is_active' => !$pack->is_active]);

    return back()->with('status', 'Statut du pack mis à jour.');
}



}
