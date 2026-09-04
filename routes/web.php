<?php

use Illuminate\Support\Facades\Route;
//Profil
use App\Http\Controllers\ProfileController;
// Repertuar
use App\Http\Controllers\ScreeningsController;
//Navbar
use App\Http\Controllers\OffersController;
use App\Http\Controllers\PricesController;
//Admin Panel
use App\Http\Controllers\AdminUsersController;
use App\Http\Controllers\AdminMoviesController;
use App\Http\Controllers\AdminReservationsController;
use App\Http\Controllers\AdminRoomsController;
use App\Http\Controllers\AdminScreeningsController;
use App\Http\Controllers\AdminGenresController;

// Repertuar
Route::get('/', [ScreeningsController::class, 'index'])->name('index');

// Dashboard
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

/*
*   ADMIN PANEL
*/

// Obsluga dostępu do panelu admina
Route::get('/admin', function () {
    return view('admin.a-panel');
})->middleware(['auth', 'verified', 'admin'])->name('admin');

// Obsługa panelu
Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->group(function () {

    // Użytkownicy -----------------
    Route::get('/users', [AdminUsersController::class, 'index'])
        ->name('admin.users.index');

    Route::get('/users/{user}/edit', [AdminUsersController::class, 'edit'])
        ->name('admin.users.edit');

    Route::put('/users/{user}', [AdminUsersController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/users/{user}', [AdminUsersController::class, 'destroy'])
        ->name('admin.users.destroy');

    // Filmy -----------------
    Route::get('/movies', [AdminMoviesController::class, 'index'])
            ->name('admin.movies.index');

    Route::get('/movies/{movie}/edit', [AdminMoviesController::class, 'edit'])
        ->name('admin.movies.edit');

    Route::put('/movies/{movie}', [AdminMoviesController::class, 'update'])
        ->name('admin.movies.update');

    Route::delete('/movies/{movie}', [AdminMoviesController::class, 'destroy'])
        ->name('admin.movies.destroy');

    // Seanse ---------------
    Route::get('/screenings', [AdminScreeningsController::class, 'index'])
            ->name('admin.screenings.index');

    Route::get('/screenings#header', [AdminScreeningsController::class, 'index'])
            ->name('admin.screenings.index#header');

    Route::get('/screenings/{screening}/edit', [AdminScreeningsController::class, 'edit'])
        ->name('admin.screenings.edit');

    Route::put('/screenings/{screening}', [AdminScreeningsController::class, 'update'])
        ->name('admin.screenings.update');

    Route::delete('/screenings/{screening}', [AdminScreeningsController::class, 'destroy'])
        ->name('admin.screenings.destroy');

    // Gatunki -----------------
    Route::get('/genres', [AdminGenresController::class, 'index'])
            ->name('admin.genres.index');

    Route::get('/genres/{genre}/edit', [AdminGenresController::class, 'edit'])
        ->name('admin.genres.edit');

    Route::put('/genres/{genre}', [AdminGenresController::class, 'update'])
        ->name('admin.genres.update');

    Route::get('/admin/genres/create', [AdminGenresController::class,'create'])
        ->name('admin.genres.create');

    Route::post('/admin/genres', [AdminGenresController::class,'store'])
        ->name('admin.genres.store');

    Route::delete('/genres/{genre}', [AdminGenresController::class, 'destroy'])
        ->name('admin.genres.destroy');

    //Zarządzanie Salami---------------
    Route::get('/rooms', [AdminRoomsController::class, 'index'])
        ->name('admin.rooms.index');

    Route::get('/rooms/{room}/edit', [AdminRoomsController::class, 'edit'])
        ->name('admin.rooms.edit');

    Route::put('/rooms/{room}', [AdminRoomsController::class,'update'])
        ->name('admin.rooms.update');
});

// Nav
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
