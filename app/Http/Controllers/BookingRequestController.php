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
            \Log::error('BookingRequest: Store failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'invio della richiesta. Riprova più tardi.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    private function sendNotificationEmail($bookingRequest)
    {
        try {
            $settings = \App\Models\Setting::getGroupedSettings();
            $hotelName = $settings['general']['hotel_name'] ?? 'Hotel Mellow';
            $contactEmail = $settings['general']['contact_email'] ?? 'ivanturturiello@gmail.com';
            
            \Log::info('BookingRequest: Attempting to send email', [
                'contact_email' => $contactEmail,
                'hotel_name' => $hotelName,
                'booking_id' => $bookingRequest->id,
                'mail_mailer' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
            ]);
            
            $data = [
                'bookingRequest' => $bookingRequest,
                'hotelName' => $hotelName
            ];

            // Use MAIL_FROM_ADDRESS as sender (must be authorized by SMTP server)
            $fromEmail = env('MAIL_FROM_ADDRESS', config('mail.from.address', 'noreply@example.com'));
            $fromName = $hotelName;
            
            Mail::send('emails.booking-notification', $data, function ($message) use ($contactEmail, $hotelName, $fromEmail, $fromName) {
                $message->from($fromEmail, $fromName)
                       ->to($contactEmail)
                       ->subject('Nuova Richiesta di Prenotazione - ' . $hotelName);
            });
            
            \Log::info('BookingRequest: Email sent successfully', [
                'to' => $contactEmail,
                'from' => $fromEmail
            ]);
            
        } catch (\Exception $e) {
            \Log::error('BookingRequest: Email sending failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
