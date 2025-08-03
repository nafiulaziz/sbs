<?php
// app/Http/Controllers/Api/BookingController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()
            ->with('service')
            ->orderBy('booking_date', 'desc')
            ->get();

        return response()->json([
            'bookings' => $bookings,
        ]);
    }

    public function store(BookingRequest $request)
    {
        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'service_id' => $request->service_id,
            'booking_date' => $request->booking_date,
            'notes' => $request->notes,
        ]);

        $booking->load('service');

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => $booking,
        ], 201);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        
        $booking->load('service');

        return response()->json([
            'booking' => $booking,
        ]);
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('update', $booking);

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Booking cancelled successfully',
            'booking' => $booking,
        ]);
    }
}