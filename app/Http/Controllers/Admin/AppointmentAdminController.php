<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query()->orderByDesc('scheduled_at');

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        if ($q = $request->query('q')) {
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
        $appointment->load('user');

        return view('admin.appointments.show', compact('appointment'));
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        $appointment->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('admin.appointments.show', $appointment)->with('status', 'Rendez-vous annulé.');
    }
}
