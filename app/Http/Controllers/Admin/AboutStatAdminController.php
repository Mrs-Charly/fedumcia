<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutStat;
use Illuminate\Http\Request;

class AboutStatAdminController extends Controller
{
    public function index()
    {
        $stats = AboutStat::query()->orderBy('sort_order')->orderByDesc('id')->paginate(30);
        return view('admin.about_stats.index', compact('stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['required','string','max:255'],
            'value' => ['required','string','max:50'],
            'note' => ['nullable','string','max:255'],
            'is_active' => ['required','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        AboutStat::create($data);

        return back()->with('status', 'Stat ajoutée.');
    }

    public function update(Request $request, AboutStat $stat)
    {
        $data = $request->validate([
            'label' => ['required','string','max:255'],
            'value' => ['required','string','max:50'],
            'note' => ['nullable','string','max:255'],
            'is_active' => ['required','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;
        $stat->update($data);

        return back()->with('status', 'Stat mise à jour.');
    }

    public function destroy(AboutStat $stat)
    {
        $stat->delete();
        return back()->with('status', 'Stat supprimée.');
    }
}
