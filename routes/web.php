<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\AppointmentController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\UserPackController;

use App\Http\Controllers\Admin\AppointmentAdminController;
use App\Http\Controllers\Admin\PackChangeRequestAdminController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [AboutController::class, 'index'])->name('about');

// Packs (public)
Route::get('/packs', [PackController::class, 'index'])->name('packs.index');
Route::get('/packs/{slug}', [PackController::class, 'show'])->name('packs.show');

// Rendez-vous (public)
Route::post('/rendezvous', [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/rendezvous/merci', [AppointmentController::class, 'thanks'])->name('appointments.thanks');
Route::get('/rendezvous/confirm/{token}', [AppointmentController::class, 'confirm'])->name('appointments.confirm');

/*
|--------------------------------------------------------------------------
| Authenticated users
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () { 
    
    // Compte utilisateur (dashboard custom)
    Route::get('/compte', [AccountController::class, 'dashboard'])->name('account.dashboard');

    // Pack utilisateur (demande de changement)
    Route::get('/mon-pack', [UserPackController::class, 'edit'])->name('pack.edit');
    Route::post('/mon-pack', [UserPackController::class, 'update'])->name('pack.update');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::view('/', 'admin.dashboard')->name('dashboard');

        // Rendez-vous
        Route::get('/appointments', [AppointmentAdminController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentAdminController::class, 'show'])->name('appointments.show');
        Route::post('/appointments/{appointment}/cancel', [AppointmentAdminController::class, 'cancel'])->name('appointments.cancel');

        // Demandes de changement de pack
        Route::get('/pack-requests', [PackChangeRequestAdminController::class, 'index'])->name('pack_requests.index');
        Route::post('/pack-requests/{packChangeRequest}/approve', [PackChangeRequestAdminController::class, 'approve'])->name('pack_requests.approve');
        Route::post('/pack-requests/{packChangeRequest}/reject', [PackChangeRequestAdminController::class, 'reject'])->name('pack_requests.reject');
    });

require __DIR__ . '/auth.php';
