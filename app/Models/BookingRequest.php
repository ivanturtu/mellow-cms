<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $fillable = [
        'checkin_date',
        'checkout_date',
        'rooms',
        'guests',
        'name',
        'email',
        'phone',
        'message',
        'status'
    ];

    protected $casts = [
        'checkin_date' => 'date',
        'checkout_date' => 'date',
        'rooms' => 'integer',
        'guests' => 'integer'
    ];
}
