<?php

namespace App\Http\Controllers;

use App\Models\Pack;

class HomeController extends Controller
{
    public function index()
    {
        $packs = Pack::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('home', compact('packs'));
    }
}
