<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function show($slug)
    {
        $room = Room::with(['activeImages', 'primaryImage'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Stanze correlate (altre stanze attive)
        $relatedRooms = Room::where('is_active', true)
            ->where('id', '!=', $room->id)
            ->limit(3)
            ->get();
        
        return view('room-details', compact('room', 'relatedRooms'));
    }
}
