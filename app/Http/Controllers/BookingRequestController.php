<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class BookingRequestController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checkin_date' => 'required|date|after_or_equal:today',
            'checkout_date' => 'required|date|after:checkin_date',
            'rooms' => 'required|integer|min:1',
            'guests' => 'required|integer|min:1',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dati non validi',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Salva la richiesta nel database
            $bookingRequest = BookingRequest::create([
                'checkin_date' => $request->checkin_date,
                'checkout_date' => $request->checkout_date,
                'rooms' => $request->rooms,
                'guests' => $request->guests,
                'email' => $request->email,
                'phone' => $request->phone,
                'status' => 'pending'
            ]);

            // Invia email di notifica
            $this->sendNotificationEmail($bookingRequest);

            return response()->json([
                'success' => true,
                'message' => 'Richiesta inviata con successo! Ti contatteremo presto.',
                'booking_id' => $bookingRequest->id
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'invio della richiesta. Riprova più tardi.'
            ], 500);
        }
    }

    private function sendNotificationEmail($bookingRequest)
    {
        $settings = \App\Models\Setting::getGroupedSettings();
        $hotelName = $settings['general']['hotel_name'] ?? 'Hotel Mellow';
        $contactEmail = $settings['general']['contact_email'] ?? 'ivanturturiello@gmail.com';
        
        $data = [
            'bookingRequest' => $bookingRequest,
            'hotelName' => $hotelName
        ];

        $fromEmail = $contactEmail ?? env('MAIL_FROM_ADDRESS', 'noreply@example.com');
        $fromName = $hotelName;
        
        Mail::send('emails.booking-notification', $data, function ($message) use ($contactEmail, $hotelName, $fromEmail, $fromName) {
            $message->from($fromEmail, $fromName)
                   ->to($contactEmail)
                   ->subject('Nuova Richiesta di Prenotazione - ' . $hotelName);
        });
    }
}
