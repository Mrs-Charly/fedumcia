<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status'); // pending|approved|hidden
        $q = $request->query('q');

        $reviews = Review::query()
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('company', 'like', "%{$q}%")
                        ->orWhere('comment', 'like', "%{$q}%");
                });
            })
            ->when($status === 'pending', fn ($query) => $query->where('is_approved', false)->where('is_visible', true))
            ->when($status === 'approved', fn ($query) => $query->where('is_approved', true)->where('is_visible', true))
            ->when($status === 'hidden', fn ($query) => $query->where('is_visible', false))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.reviews.index', compact('reviews', 'q', 'status'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'is_approved' => true,
            'is_visible'  => true,
        ]);

        return back()->with('status', 'Avis approuvé.');
    }

    public function hide(Review $review)
    {
        $review->update([
            'is_visible' => false,
        ]);

        return back()->with('status', 'Avis masqué.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('status', 'Avis supprimé.');
    }
}
