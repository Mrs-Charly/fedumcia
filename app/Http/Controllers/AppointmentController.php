<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Mail\AppointmentConfirmationMail;
use App\Models\Appointment;
use App\Models\PackChangeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();

        /**
         * Vérification logique :
         * un seul rendez-vous par créneau d’1h
         */
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

        $token = (string) Str::uuid();

        $appointment = Appointment::create([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'],
            'company_name' => $data['company_name'] ?? null,            
            'company_address' => $data['company_address'] ?? null,
            'company_postal_code' => $data['company_postal_code'] ?? null,
            'company_city' => $data['company_city'] ?? null,

            'scheduled_at'    => $data['scheduled_at'],
            'desired_pack_id' => $data['desired_pack_id'] ?? null,

            'status'             => 'pending',
            'confirmation_token' => $token,

            // RGPD
            'consent'            => true,
            'consent_at'         => now(),
            'consent_ip'         => $request->ip(),
            'consent_user_agent' => substr((string) $request->userAgent(), 0, 512),
        ]);

        $confirmUrl = route('appointments.confirm', ['token' => $token]);

        Mail::to($appointment->email)
            ->send(new AppointmentConfirmationMail($appointment, $confirmUrl));

        return redirect()->route('appointments.thanks');
    }

    public function thanks()
    {
        return view('appointments.thanks');
    }

    public function confirm(string $token)
    {
        $appointment = Appointment::where('confirmation_token', $token)->firstOrFail();

        if ($appointment->status === 'confirmed') {
            return view('appointments.confirmed', ['already' => true]);
        }

        $user = User::where('email', $appointment->email)->first();

        if (!$user) {
            $user = User::create([
                'name'              => trim($appointment->first_name . ' ' . $appointment->last_name),
                'email'             => $appointment->email,
                'password'          => bcrypt(Str::random(32)),
                'email_verified_at' => now(),
                'is_admin'          => false,
                'pack_id'           => null,
            ]);
        }

        // 1) Confirmer le RDV
        $appointment->update([
            'user_id'      => $user->id,
            'status'       => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // 2) Si un pack a été choisi : créer une demande visible côté admin
        if (!empty($appointment->desired_pack_id)) {
            $alreadyPending = PackChangeRequest::where('user_id', $user->id)
                ->where('status', 'pending')
                ->exists();

            if (!$alreadyPending) {
                PackChangeRequest::create([
                    'user_id'           => $user->id,
                    'current_pack_id'   => $user->pack_id,
                    'requested_pack_id' => $appointment->desired_pack_id,
                    'status'            => 'pending',
                    'message'           => 'Demande automatique suite à la confirmation du rendez-vous.',
                ]);
            }
        }

        // 3) Envoyer un lien pour définir le mot de passe
        Password::sendResetLink(['email' => $user->email]);

        return view('appointments.confirmed', ['already' => false]);
    }
}
