<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Carbon\Carbon;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email',
            'phone'           => 'required|string|max:30',
            'company_name'    => 'nullable|string|max:255',

            'scheduled_at'    => 'required|date',
            'desired_pack_id' => 'nullable|exists:packs,id',

            'consent'         => 'accepted',

            'company_address' => 'nullable|string|max:255',
            'company_postal_code' => 'nullable|string|max:20',
            'company_city' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.required' => 'Merci de choisir une date et une heure.',
            'scheduled_at.date'     => 'La date de rendez-vous est invalide.',
            'consent.accepted'      => 'Vous devez accepter le traitement de vos données pour valider votre demande.',
        ];
    }

    public function withValidator(Validator $validator)
{
    $validator->after(function ($validator) {
        if (!$this->scheduled_at) return;

        $dt = Carbon::parse($this->scheduled_at);

        if ($dt->lte(now())) {
            $validator->errors()->add('scheduled_at', 'La date doit être dans le futur.');
        }

        if ($dt->isWeekend()) {
            $validator->errors()->add('scheduled_at', 'Les rendez-vous sont possibles du lundi au vendredi.');
        }

        // 08:00 → 17:00 (dernier créneau)
        if ($dt->hour < 8 || $dt->hour > 17) {
            $validator->errors()->add('scheduled_at', 'Les horaires sont de 8h à 18h (dernier créneau 17h–18h).');
        }

        if ($dt->minute !== 0) {
            $validator->errors()->add('scheduled_at', 'Les rendez-vous se prennent sur des créneaux d’1h (minutes = 00).');
        }
    });
}
}
