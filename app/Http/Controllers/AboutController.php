<?php

namespace App\Http\Controllers;

use App\Models\AboutStat;
use App\Models\PortfolioProject;
use App\Models\SocialLink;

class AboutController extends Controller
{
    public function index()
    {
        $projects = PortfolioProject::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $stats = AboutStat::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $socialLinks = SocialLink::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('about', compact('projects', 'stats', 'socialLinks'));
    }
}
