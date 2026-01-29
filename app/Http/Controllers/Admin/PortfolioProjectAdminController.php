<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioProjectAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $active = $request->query('active');

        $projects = PortfolioProject::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('client', 'like', "%{$q}%")
                        ->orWhere('category', 'like', "%{$q}%")
                        ->orWhere('slug', 'like', "%{$q}%");
                });
            })
            ->when($active !== null && $active !== '', fn($query) => $query->where('is_active', (bool)((int)$active)))
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.portfolio.index', compact('projects', 'q', 'active'));
    }

    public function create()
    {
        return view('admin.portfolio.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'slug' => ['nullable','string','max:255','unique:portfolio_projects,slug'],
            'client' => ['nullable','string','max:255'],
            'category' => ['nullable','string','max:255'],
            'excerpt' => ['nullable','string','max:1000'],
            'content' => ['nullable','string'],
            'website_url' => ['nullable','url','max:255'],
            'instagram_url' => ['nullable','url','max:255'],
            'facebook_url' => ['nullable','url','max:255'],
            'tiktok_url' => ['nullable','url','max:255'],
            'linkedin_url' => ['nullable','url','max:255'],
            'is_active' => ['required','boolean'],
            'sort_order' => ['nullable','integer','min:0'],

            'cover' => ['nullable','image','max:4096'],
            'gallery' => ['nullable','array','max:12'],
            'gallery.*' => ['image','max:4096'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('cover')) {
            $data['cover_path'] = $request->file('cover')->store('portfolio', 'public');
        }

        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $img) {
                $galleryPaths[] = $img->store('portfolio', 'public');
            }
        }
        $data['gallery_paths'] = $galleryPaths ?: null;

        PortfolioProject::create($data);

        return redirect()->route('admin.portfolio.index')->with('status', 'Projet créé.');
    }

    public function edit(PortfolioProject $project)
    {
        return view('admin.portfolio.edit', compact('project'));
    }

    public function update(Request $request, PortfolioProject $project)
    {
        $data = $request->validate([
            'title' => ['required','string','max:255'],
            'slug' => ['required','string','max:255','unique:portfolio_projects,slug,' . $project->id],
            'client' => ['nullable','string','max:255'],
            'category' => ['nullable','string','max:255'],
            'excerpt' => ['nullable','string','max:1000'],
            'content' => ['nullable','string'],
            'website_url' => ['nullable','url','max:255'],
            'instagram_url' => ['nullable','url','max:255'],
            'facebook_url' => ['nullable','url','max:255'],
            'tiktok_url' => ['nullable','url','max:255'],
            'linkedin_url' => ['nullable','url','max:255'],
            'is_active' => ['required','boolean'],
            'sort_order' => ['nullable','integer','min:0'],

            'cover' => ['nullable','image','max:4096'],
            'gallery' => ['nullable','array','max:12'],
            'gallery.*' => ['image','max:4096'],

            'remove_cover' => ['nullable','boolean'],
            'remove_gallery' => ['nullable','boolean'],
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        // cover
        if (!empty($data['remove_cover']) && $project->cover_path) {
            Storage::disk('public')->delete($project->cover_path);
            $project->cover_path = null;
        }
        if ($request->hasFile('cover')) {
            if ($project->cover_path) Storage::disk('public')->delete($project->cover_path);
            $project->cover_path = $request->file('cover')->store('portfolio', 'public');
        }

        // gallery
        if (!empty($data['remove_gallery']) && $project->gallery_paths) {
            foreach ($project->gallery_paths as $p) Storage::disk('public')->delete($p);
            $project->gallery_paths = null;
        }

        if ($request->hasFile('gallery')) {
            $new = [];
            foreach ($request->file('gallery') as $img) {
                $new[] = $img->store('portfolio', 'public');
            }
            // on remplace la galerie
            if ($project->gallery_paths) {
                foreach ($project->gallery_paths as $p) Storage::disk('public')->delete($p);
            }
            $project->gallery_paths = $new;
        }

        $project->fill([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'client' => $data['client'] ?? null,
            'category' => $data['category'] ?? null,
            'excerpt' => $data['excerpt'] ?? null,
            'content' => $data['content'] ?? null,
            'website_url' => $data['website_url'] ?? null,
            'instagram_url' => $data['instagram_url'] ?? null,
            'facebook_url' => $data['facebook_url'] ?? null,
            'tiktok_url' => $data['tiktok_url'] ?? null,
            'linkedin_url' => $data['linkedin_url'] ?? null,
            'is_active' => (bool)$data['is_active'],
            'sort_order' => (int)$data['sort_order'],
        ])->save();

        return back()->with('status', 'Projet mis à jour.');
    }

    public function destroy(PortfolioProject $project)
    {
        if ($project->cover_path) Storage::disk('public')->delete($project->cover_path);
        if ($project->gallery_paths) {
            foreach ($project->gallery_paths as $p) Storage::disk('public')->delete($p);
        }

        $project->delete();

        return redirect()->route('admin.portfolio.index')->with('status', 'Projet supprimé.');
    }

    public function toggle(PortfolioProject $project)
    {
        $project->update(['is_active' => !$project->is_active]);
        return back()->with('status', 'Statut mis à jour.');
    }
}
