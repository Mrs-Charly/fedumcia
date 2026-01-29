<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkAdminController extends Controller
{
    public function index()
    {
        $links = SocialLink::query()->orderBy('sort_order')->orderByDesc('id')->paginate(30);
        return view('admin.social_links.index', compact('links'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'platform' => ['required','string','max:50'],
            'label' => ['nullable','string','max:100'],
            'url' => ['required','url','max:255'],
            'is_active' => ['required','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        SocialLink::create($data);

        return back()->with('status', 'Lien ajouté.');
    }

    public function update(Request $request, SocialLink $link)
    {
        $data = $request->validate([
            'platform' => ['required','string','max:50'],
            'label' => ['nullable','string','max:100'],
            'url' => ['required','url','max:255'],
            'is_active' => ['required','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $link->update($data);

        return back()->with('status', 'Lien mis à jour.');
    }

    public function destroy(SocialLink $link)
    {
        $link->delete();
        return back()->with('status', 'Lien supprimé.');
    }
}