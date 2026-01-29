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
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\PackAdminController;
use App\Http\Controllers\Admin\ReviewAdminController;

use App\Http\Controllers\ReviewController;

use App\Http\Controllers\Admin\PartnerAdminController;
use App\Http\Controllers\Admin\PortfolioProjectAdminController;
use App\Http\Controllers\Admin\AboutStatAdminController;
use App\Http\Controllers\Admin\SocialLinkAdminController;

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

// Avis (public)
Route::post('/avis', [ReviewController::class, 'store'])->name('reviews.store');

/*
|--------------------------------------------------------------------------
| Authenticated users
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/compte', [AccountController::class, 'dashboard'])->name('account.dashboard');

    Route::get('/mon-pack', [UserPackController::class, 'edit'])->name('pack.edit');
    Route::post('/mon-pack', [UserPackController::class, 'update'])->name('pack.update');

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

        Route::view('/', 'admin.dashboard')->name('dashboard');

        // Packs (admin CRUD)
        Route::get('/packs', [PackAdminController::class, 'index'])->name('packs.index');
        Route::get('/packs/create', [PackAdminController::class, 'create'])->name('packs.create');
        Route::post('/packs', [PackAdminController::class, 'store'])->name('packs.store');
        Route::get('/packs/{pack}/edit', [PackAdminController::class, 'edit'])->name('packs.edit');
        Route::put('/packs/{pack}', [PackAdminController::class, 'update'])->name('packs.update');
        Route::delete('/packs/{pack}', [PackAdminController::class, 'destroy'])->name('packs.destroy');

        Route::patch('/packs/{pack}/toggle', [PackAdminController::class, 'toggleActive'])
            ->name('packs.toggle');

        // Rendez-vous
        Route::get('/appointments', [AppointmentAdminController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/{appointment}', [AppointmentAdminController::class, 'show'])->name('appointments.show');
        Route::post('/appointments/{appointment}/cancel', [AppointmentAdminController::class, 'cancel'])->name('appointments.cancel');

        Route::get('/appointments/{appointment}/edit', [AppointmentAdminController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{appointment}', [AppointmentAdminController::class, 'update'])->name('appointments.update');

        // Demandes de pack
        Route::get('/pack-requests', [PackChangeRequestAdminController::class, 'index'])->name('pack_requests.index');
        Route::post('/pack-requests/{packChangeRequest}/approve', [PackChangeRequestAdminController::class, 'approve'])->name('pack_requests.approve');
        Route::post('/pack-requests/{packChangeRequest}/reject', [PackChangeRequestAdminController::class, 'reject'])->name('pack_requests.reject');

        // Utilisateurs (admin CRUD)
        Route::get('/users', [UserAdminController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserAdminController::class, 'create'])->name('users.create');
        Route::post('/users', [UserAdminController::class, 'store'])->name('users.store');

        Route::get('/users/{user}', [UserAdminController::class, 'show'])->name('users.show');

        Route::get('/users/{user}/edit', [UserAdminController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserAdminController::class, 'update'])->name('users.update');

        Route::put('/users/{user}/pack', [UserAdminController::class, 'updatePack'])->name('users.pack.update');

        Route::delete('/users/{user}', [UserAdminController::class, 'destroy'])->name('users.destroy');

        // Avis (admin)
        Route::get('/reviews', [ReviewAdminController::class, 'index'])->name('reviews.index');
        Route::post('/reviews/{review}/approve', [ReviewAdminController::class, 'approve'])->name('reviews.approve');
        Route::post('/reviews/{review}/hide', [ReviewAdminController::class, 'hide'])->name('reviews.hide');
        Route::delete('/reviews/{review}', [ReviewAdminController::class, 'destroy'])->name('reviews.destroy');

        Route::get('/partners', [PartnerAdminController::class, 'index'])->name('partners.index');
        Route::get('/partners/create', [PartnerAdminController::class, 'create'])->name('partners.create');
        Route::post('/partners', [PartnerAdminController::class, 'store'])->name('partners.store');
        Route::get('/partners/{partner}/edit', [PartnerAdminController::class, 'edit'])->name('partners.edit');
        Route::put('/partners/{partner}', [PartnerAdminController::class, 'update'])->name('partners.update');
        Route::delete('/partners/{partner}', [PartnerAdminController::class, 'destroy'])->name('partners.destroy');

        // toggle actif/inactif (bouton)
        Route::patch('/partners/{partner}/toggle', [PartnerAdminController::class, 'toggleActive'])->name('partners.toggle');

Route::get('/portfolio', [PortfolioProjectAdminController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/create', [PortfolioProjectAdminController::class, 'create'])->name('portfolio.create');
Route::post('/portfolio', [PortfolioProjectAdminController::class, 'store'])->name('portfolio.store');
Route::get('/portfolio/{project}/edit', [PortfolioProjectAdminController::class, 'edit'])->name('portfolio.edit');
Route::put('/portfolio/{project}', [PortfolioProjectAdminController::class, 'update'])->name('portfolio.update');
Route::delete('/portfolio/{project}', [PortfolioProjectAdminController::class, 'destroy'])->name('portfolio.destroy');
Route::patch('/portfolio/{project}/toggle', [PortfolioProjectAdminController::class, 'toggle'])->name('portfolio.toggle');

Route::get('/about-stats', [AboutStatAdminController::class, 'index'])->name('about_stats.index');
Route::post('/about-stats', [AboutStatAdminController::class, 'store'])->name('about_stats.store');
Route::put('/about-stats/{stat}', [AboutStatAdminController::class, 'update'])->name('about_stats.update');
Route::delete('/about-stats/{stat}', [AboutStatAdminController::class, 'destroy'])->name('about_stats.destroy');

Route::get('/social-links', [SocialLinkAdminController::class, 'index'])->name('social_links.index');
Route::post('/social-links', [SocialLinkAdminController::class, 'store'])->name('social_links.store');
Route::put('/social-links/{link}', [SocialLinkAdminController::class, 'update'])->name('social_links.update');
Route::delete('/social-links/{link}', [SocialLinkAdminController::class, 'destroy'])->name('social_links.destroy');

    });

require __DIR__ . '/auth.php';
