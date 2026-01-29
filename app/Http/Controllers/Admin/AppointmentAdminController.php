<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Pack;
use Illuminate\Http\Request;

class AppointmentAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $q = $request->query('q');

        $query = Appointment::query()->orderByDesc('scheduled_at');

        if ($status) {
            $query->where('status', $status);
        }

        if ($q) {
            $query->where(function ($sub) use ($q) {
                $sub->where('email', 'like', "%{$q}%")
                    ->orWhere('company_name', 'like', "%{$q}%")
                    ->orWhere('first_name', 'like', "%{$q}%")
                    ->orWhere('last_name', 'like', "%{$q}%");
            });
        }

        $appointments = $query->paginate(20)->withQueryString();

        return view('admin.appointments.index', compact('appointments', 'status', 'q'));
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['user', 'desiredPack']);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $packs = Pack::orderBy('sort_order')->get();

        return view('admin.appointments.edit', compact('appointment', 'packs'));
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        $appointment->update($data);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('status', 'Rendez-vous mis à jour.');
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('admin.appointments.show', $appointment)
            ->with('status', 'Rendez-vous annulé.');
    }
}
