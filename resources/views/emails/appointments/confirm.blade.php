<p>Bonjour {{ $appointment->first_name }},</p>

<p>Nous avons bien reçu votre demande de rendez-vous pour <strong>{{ $appointment->company_name }}</strong>.</p>

<p><strong>Date souhaitée :</strong> {{ $appointment->scheduled_at->format('d/m/Y H:i') }}</p>

<p><strong>Pack souhaité :</strong>
    {{ $appointment->desiredPack?->name ?? 'Non précisé' }}
</p>

<p>Veuillez confirmer votre rendez-vous en cliquant ici :</p>

<p><a href="{{ $confirmUrl }}">{{ $confirmUrl }}</a></p>

<p>Si vous n’êtes pas à l’origine de cette demande, vous pouvez ignorer cet email.</p>

<p>Fedumcia</p>
