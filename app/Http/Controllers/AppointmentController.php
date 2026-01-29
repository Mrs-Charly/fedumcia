<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Models\PackChangeRequest;
use App\Models\User;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();

        // Anti double réservation
        $alreadyTaken = Appointment::where('scheduled_at', $data['scheduled_at'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($alreadyTaken) {
            return back()
                ->withErrors([
                    'scheduled_at' => 'Ce créneau est déjà réservé. Merci d’en choisir un autre.'
                ])
                ->withInput();
        }

        // Associer à un user (création auto si absent)
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            $user = User::create([
                'name'              => trim(($data['first_name'] ?? '') . ' ' . ($data['last_name'] ?? '')),
                'email'             => $data['email'],
                'password'          => bcrypt(Str::random(32)),
                'email_verified_at' => now(),
                'is_admin'          => false,
                'pack_id'           => null,
            ]);
        }

        // Créer le RDV directement confirmé (plus de mail)
        Appointment::create([
            'user_id'      => $user->id,
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'],

            'company_name'        => $data['company_name'] ?? null,
            'company_address'     => $data['company_address'] ?? null,
            'company_postal_code' => $data['company_postal_code'] ?? null,
            'company_city'        => $data['company_city'] ?? null,

            'scheduled_at'    => $data['scheduled_at'],
            'desired_pack_id' => $data['desired_pack_id'] ?? null,

            'status'        => 'confirmed',
            'confirmed_at'  => now(),
            'confirmation_token' => null,

            // RGPD
            'consent'            => true,
            'consent_at'         => now(),
            'consent_ip'         => $request->ip(),
            'consent_user_agent' => substr((string) $request->userAgent(), 0, 512),
        ]);

        // Si un pack est choisi : créer une demande de changement (pending)
        if (!empty($data['desired_pack_id'])) {
            $alreadyPending = PackChangeRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->exists();

            if (!$alreadyPending) {
                PackChangeRequest::create([
                    'user_id'           => $user->id,
                    'current_pack_id'   => $user->pack_id,
                    'requested_pack_id' => $data['desired_pack_id'],
                    'status'            => 'pending',
                    'message'           => 'Demande automatique suite à la prise de rendez-vous.',
                ]);
            }
        }

        return redirect()
            ->route('appointments.thanks')
            ->with('status', 'Votre rendez-vous est bien enregistré.');
    }

    public function thanks()
    {
        return view('appointments.thanks');
    }
}
