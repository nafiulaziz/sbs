<?php
// app/Http/Requests/BookingRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class BookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:now',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'booking_date.after' => 'Booking date must be in the future.',
        ];
    }
}