<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:2000'],
        ]);

        // Anti-doublon simple (même nom + même commentaire dans les dernières 24h)
        $exists = Review::where('name', $data['name'])
            ->where('comment', $data['comment'])
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($exists) {
            return back()->with('status', 'Avis déjà envoyé récemment. Merci.');
        }

        Review::create([
            'name'        => $data['name'],
            'company'     => $data['company'] ?? null,
            'rating'      => $data['rating'],
            'comment'     => $data['comment'],
            'is_approved' => false,
            'is_visible'  => true,
        ]);

        return back()->with('status', 'Merci ! Votre avis a bien été envoyé et sera publié après validation.');
    }
}
