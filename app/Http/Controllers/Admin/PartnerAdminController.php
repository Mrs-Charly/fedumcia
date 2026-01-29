<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PartnerAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $active = $request->query('active'); // '1'|'0'|null

        $partners = Partner::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('website_url', 'like', "%{$q}%");
                });
            })
            ->when($active !== null && $active !== '', function ($query) use ($active) {
                $query->where('is_active', (bool)((int)$active));
            })
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.partners.index', compact('partners', 'q', 'active'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'website_url'=> ['nullable', 'url', 'max:255'],
            'logo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'  => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners', 'public');
        }

        Partner::create([
            'name'       => $data['name'],
            'website_url'=> $data['website_url'] ?? null,
            'logo_path'  => $logoPath,
            'is_active'  => (bool)$data['is_active'],
            'sort_order' => $data['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.partners.index')->with('status', 'Partenaire créé.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'website_url'=> ['nullable', 'url', 'max:255'],
            'logo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_active'  => ['required', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'remove_logo'=> ['nullable', 'boolean'],
        ]);

        // supprimer logo si demandé
        if (!empty($data['remove_logo']) && $partner->logo_path) {
            Storage::disk('public')->delete($partner->logo_path);
            $partner->logo_path = null;
        }

        // remplacer logo si upload
        if ($request->hasFile('logo')) {
            if ($partner->logo_path) {
                Storage::disk('public')->delete($partner->logo_path);
            }
            $partner->logo_path = $request->file('logo')->store('partners', 'public');
        }

        $partner->name = $data['name'];
        $partner->website_url = $data['website_url'] ?? null;
        $partner->is_active = (bool)$data['is_active'];
        $partner->sort_order = $data['sort_order'] ?? 0;

        $partner->save();

        return back()->with('status', 'Partenaire mis à jour.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo_path) {
            Storage::disk('public')->delete($partner->logo_path);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')->with('status', 'Partenaire supprimé.');
    }
}
