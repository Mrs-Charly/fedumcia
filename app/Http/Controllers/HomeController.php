<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\Appointment;
use App\Models\Partner;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $packs = Pack::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Créneaux pris sur 14 jours
        $start = now()->startOfDay();
        $end   = now()->addDays(14)->endOfDay();

        $taken = Appointment::query()
            ->whereBetween('scheduled_at', [$start, $end])
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('scheduled_at')
            ->map(fn ($dt) => Carbon::parse($dt)->format('Y-m-d H:00:00'))
            ->values()
            ->all();

        // Avis (si table reviews existe)
        $reviews = collect();
        if (Schema::hasTable('reviews')) {
            $reviews = Review::query()
                ->where('is_approved', true)
                ->where('is_visible', true)
                ->orderByDesc('created_at')
                ->limit(9)
                ->get();
        }

        // Partenaires (si table partners existe)
        $partners = collect();
        if (Schema::hasTable('partners')) {
            $partners = Partner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get();
        }

        return view('home', compact('packs', 'taken', 'reviews', 'partners'));
    }
}
