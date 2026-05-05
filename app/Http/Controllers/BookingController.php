<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with('room')->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all();
        return view('bookings.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'nullable|string|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        //Load Room (Business data)
        $room = Room::findOrFail($request->room_id);

        // calculate night
        $checkIn = new \DateTime($request->check_in);
        $checkOut = new \DateTime($request->check_out);
        $nights = $checkIn->diff($checkOut)->days;
        $totalPrice = $room->price * $nights;

        // save booking
        Booking::create([
            'room_id' => $room->id,
            'guest_name' => $request->guest_name,
            'guest_phone' => $request->guest_phone,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully');
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
    public function edit(Booking $booking)
    {
        $rooms = Room::all();

        return view('bookings.edit', compact('booking', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'nullable|string',
            'guest_phone' => 'nullable|string',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $room = Room::findOrFail($request->room_id);

        $days = (new \DateTime($request->check_in))
            ->diff(new \DateTime($request->check_out))
            ->days;

        $booking->update([
            'room_id' => $room->id,
            'guest_name' => $request->guest_name,
            'guest_phone' => $request->guest_phone,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $room->price * $days,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Room deleted successfully');
    }
}
