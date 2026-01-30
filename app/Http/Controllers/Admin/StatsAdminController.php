<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Pack;
use App\Models\Review;
use Illuminate\Http\Request;

class StatsAdminController extends Controller
{
    public function index(Request $request)
    {
        // Période par défaut : 30 jours
        $from = $request->query('from', now()->subDays(30)->toDateString());
        $to   = $request->query('to', now()->toDateString());

        $start = now()->parse($from)->startOfDay();
        $end   = now()->parse($to)->endOfDay();

        // RDV
        $appointmentsTotal = Appointment::whereBetween('scheduled_at', [$start, $end])->count();
        $appointmentsPending = Appointment::whereBetween('scheduled_at', [$start, $end])->where('status', 'pending')->count();
        $appointmentsConfirmed = Appointment::whereBetween('scheduled_at', [$start, $end])->where('status', 'confirmed')->count();
        $appointmentsCancelled = Appointment::whereBetween('scheduled_at', [$start, $end])->where('status', 'cancelled')->count();

        // Avis
        $reviewsTotal = Review::whereBetween('created_at', [$start, $end])->count();
        $reviewsApproved = Review::whereBetween('created_at', [$start, $end])->where('is_approved', true)->where('is_visible', true)->count();
        $reviewsPending = Review::whereBetween('created_at', [$start, $end])->where('is_approved', false)->where('is_visible', true)->count();
        $reviewsHidden = Review::whereBetween('created_at', [$start, $end])->where('is_visible', false)->count();

        // Packs (global + demande de RDV)
        $packsActive = Pack::where('is_active', true)->count();
        $packsTotal = Pack::count();

        // Packs demandés via RDV sur la période
        $topRequestedPacks = Appointment::query()
            ->whereBetween('scheduled_at', [$start, $end])
            ->whereNotNull('desired_pack_id')
            ->selectRaw('desired_pack_id, COUNT(*) as total')
            ->groupBy('desired_pack_id')
            ->orderByDesc('total')
            ->with('desiredPack') // relation à ajouter si pas déjà faite
            ->limit(10)
            ->get();

        return view('admin.stats.index', compact(
            'from', 'to',
            'appointmentsTotal', 'appointmentsPending', 'appointmentsConfirmed', 'appointmentsCancelled',
            'reviewsTotal', 'reviewsApproved', 'reviewsPending', 'reviewsHidden',
            'packsActive', 'packsTotal',
            'topRequestedPacks'
        ));
    }
}
