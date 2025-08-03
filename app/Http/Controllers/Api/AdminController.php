<?php
// app/Http/Controllers/Api/AdminController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function bookings()
    {
        $bookings = Booking::with(['user', 'service'])
            ->orderBy('booking_date', 'desc')
            ->get();

        return response()->json([
            'bookings' => $bookings,
        ]);
    }

    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Booking status updated successfully',
            'booking' => $booking->load(['user', 'service']),
        ]);
    }

    public function dashboard()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_services' => Service::count(),
            'active_services' => Service::where('status', 'active')->count(),
            'total_customers' => User::where('role', 'customer')->count(),
        ];

        return response()->json([
            'stats' => $stats,
        ]);
    }
}