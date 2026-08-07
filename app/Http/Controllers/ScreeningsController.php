<?php

namespace App\Http\Controllers;

use App\Models\Screening;

class ScreeningsController extends Controller
{
    public function index()
    {
        $screenings = Screening::with('movie', 'room')
            ->where('start_time', '>=', now())
            ->orderBy('start_time')
            ->get();

        return view(
            'welcome',
            compact('screenings')
        );
    }
    // public function index()
    // {
    //     $screenings = Screening::with([
    //         'movie',
    //         'room'
    //     ])
    //     ->orderBy('start_time')
    //     ->get();


    //     return view('welcome', compact('screenings'));
    // }

    public function show(Screening $screening)
    {

        $screening->load([
            'movie',
            'room.seats'
        ]);


        return view(
            'screenings.show',
            compact('screening')
        );
    }
}
