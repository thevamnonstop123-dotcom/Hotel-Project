<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Room, Amenity};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::with(['amenities'])->get();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $amenities = Amenity::all();
        return view('rooms.create', compact('amenities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([  // good habit validate first (difend rule)
            'room_number' => 'required',
            'price' => 'required | numeric',
            'bed_type' => 'required',
            'has_wifi' => 'required | boolean'
        ]);

        DB::transaction(function () use ($request) {

            $room = Room::create($request->only([
                'room_number',
                'price',
                'bed_type',
                'has_wifi'
            ]));

            if ($request->has('amenities')) {
                // $room->amenities()->attach($request->amenities); // attach add realationship
                $room->amenities()->sync($request->amenities); // replace relationship
            }
        });

        return redirect()->route('rooms.index')->with('success', 'Room created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $amenities = Amenity::all();
        return view('rooms.edit', compact('room', 'amenities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required',
            'price' => 'required | numeric',
            'bed_type' => 'required',
            'has_wifi' => 'required | boolean'
        ]);

        $room->update($request->only([
            'room_number',
            'price',
            'bed_type',
            'has_wifi'
        ]));

        //  sync amenities
        $room->amenities()->sync($request->amenities ?? []);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully');
    }
}
