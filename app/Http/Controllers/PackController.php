<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\Http\Request;

class PackController extends Controller
{
    public function index()
    {
        $packs = Pack::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('packs.index', compact('packs'));
    }

    public function show(string $slug)
    {
        $pack = Pack::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('packs.show', compact('pack'));
    }
}
