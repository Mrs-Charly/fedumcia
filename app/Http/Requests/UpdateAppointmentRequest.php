<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // déjà protégé par middleware admin
    }

    public function rules(): array
    {
        return [
            'company_name'    => 'nullable|string|max:255',
            'scheduled_at'    => ['required', 'date'],
            'desired_pack_id' => 'nullable|exists:packs,id',
            'admin_note'      => 'nullable|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $dt = Carbon::parse($this->scheduled_at);

            if ($dt->isWeekend()) {
                $validator->errors()->add(
                    'scheduled_at',
                    'Les rendez-vous sont possibles uniquement du lundi au vendredi.'
                );
            }

            if ($dt->hour < 8 || $dt->hour > 17) {
                $validator->errors()->add(
                    'scheduled_at',
                    'Les rendez-vous sont possibles entre 08h et 18h (dernier créneau à 17h).'
                );
            }

            if ($dt->minute !== 0) {
                $validator->errors()->add(
                    'scheduled_at',
                    'Les rendez-vous doivent être sur des créneaux d’une heure (minutes = 00).'
                );
            }
        });
    }
}
