<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScreeningsController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\PricesController;

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

Route::get('/admin', function () {
    return view('admin.index');
})->middleware(['auth', 'verified', 'admin'])->name('admin');

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
