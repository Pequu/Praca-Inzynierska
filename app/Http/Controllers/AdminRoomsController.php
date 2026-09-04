<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRoomsController extends Controller
{
    public function index()
    {
        $rooms = Room::withCount('seats')
            ->orderBy('id')
            ->get();

        return view('admin.rooms.index', compact('rooms'));
    }


    public function edit(Room $room)
    {
        $room->load('seats');

        return view('admin.rooms.edit', [
            'room' => $room,
            'seats' => $room->seats,
        ]);
    }


    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'seats' => ['required', 'array'],

            'seats.*.id' => ['nullable', 'integer'],

            'seats.*.row' => [
                'required',
                'string',
                'max:10'
            ],

            'seats.*.number' => [
                'required',
                'integer',
                'min:1'
            ],

            'seats.*.x' => [
                'required',
                'integer',
                'min:0'
            ],

            'seats.*.y' => [
                'required',
                'integer',
                'min:0'
            ],

            'seats.*.type' => [
                'required',
                'in:standard,wheelchair,couch'
            ],

            'seats.*.group_id' => [
                'nullable',
                'integer'
            ],
        ]);


        DB::transaction(function () use ($room, $data) {

            $existingIds = $room->seats()
                ->pluck('id')
                ->toArray();

            $sentIds = collect($data['seats'])
                ->pluck('id')
                ->filter()
                ->map(fn ($id) => (int) $id)
                ->toArray();


            /*
             * Usuwamy miejsca,
             * których nie ma już w edytorze.
             */
            $idsToDelete = array_diff(
                $existingIds,
                $sentIds
            );

            if (!empty($idsToDelete)) {

                $room->seats()
                    ->whereIn('id', $idsToDelete)
                    ->delete();
            }


            /*
             * Zapisujemy miejsca.
             */
            foreach ($data['seats'] as $seatData) {

                $seatId = $seatData['id'] ?? null;


                /*
                 * Istniejące miejsce.
                 */
                if (
                    $seatId &&
                    in_array((int) $seatId, $existingIds)
                ) {

                    $seat = $room->seats()
                        ->where('id', $seatId)
                        ->first();

                    if (!$seat) {
                        continue;
                    }

                    $seat->update([
                        'row' => $seatData['row'],
                        'number' => $seatData['number'],
                        'x' => $seatData['x'],
                        'y' => $seatData['y'],
                        'type' => $seatData['type'],
                        'group_id' => $seatData['group_id'] ?? null,
                    ]);

                }


                /*
                 * Nowe miejsce.
                 */
                else {

                    $room->seats()->create([
                        'row' => $seatData['row'],
                        'number' => $seatData['number'],
                        'x' => $seatData['x'],
                        'y' => $seatData['y'],
                        'type' => $seatData['type'],
                        'group_id' => $seatData['group_id'] ?? null,
                    ]);
                }
            }
        });


        return response()->json([
            'success' => true,
            'message' => 'Układ sali został zapisany.'
        ]);
    }
}
