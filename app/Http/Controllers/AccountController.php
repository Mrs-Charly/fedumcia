<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $appointments = $user->appointments()->orderByDesc('scheduled_at')->get();

        return view('account.dashboard', compact('user', 'appointments'));
    }
}
