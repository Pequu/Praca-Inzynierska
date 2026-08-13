<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreeningsController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\AdminUsersController;

Route::get('/', [ScreeningsController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Obsluga wyswietlania seansow na stronie glowniej
Route::get('/screenings', [ScreeningsController::class, 'index'])
    ->name('screenings.index');

// Obsluga wyswietlania informacji o konkretnym seansie
Route::get('/screenings/{screening}',
    [ScreeningsController::class, 'show']
)->name('screenings.show');

// Obsluga rezerwacji miejsc na seans
Route::get(
    '/screenings/{id}/seats',
    [ScreeningsController::class, 'seats']
)->name('screenings.seats');

// Obsluga dostępu do panelu admina
Route::get('/admin', function () {
    return view('admin.a-panel');
})->middleware(['auth', 'verified', 'admin'])->name('admin');

// Obsługa do edycji użytkowników
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->group(function () {

    Route::get('/users', [AdminUsersController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/users/{user}/edit', [AdminUsersController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/users/{user}', [AdminUsersController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/users/{user}', [AdminUsersController::class, 'destroy'])
        ->name('admin.users.destroy');
});

Route::get('offers',
    [OffersController::class, 'offers'])
->name('offers');

Route::get('prices',
    [PricesController::class, 'prices'])
->name('prices');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
