<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display the contact page
     */
    public function index()
    {
        $settings = Setting::getGroupedSettings();
        return view('contact.index', compact('settings'));
    }

    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dati non validi',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Save message to database
            $contactMessage = ContactMessage::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new'
            ]);

            // Send email notification
            $this->sendContactEmail($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Messaggio inviato con successo! Ti risponderemo presto.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'invio del messaggio. Riprova più tardi.'
            ], 500);
        }
    }

    /**
     * Send contact form email
     */
    private function sendContactEmail($data)
    {
        $settings = Setting::getGroupedSettings();
        $hotelName = $settings['general']['hotel_name'] ?? 'Hotel Mellow';
        $contactEmail = $settings['general']['contact_email'] ?? 'ivanturturiello@gmail.com';

        Mail::send('emails.contact-notification', [
            'data' => $data,
            'hotelName' => $hotelName,
            'settings' => $settings
        ], function ($message) use ($data, $hotelName, $contactEmail) {
            $message->to($contactEmail)
                ->subject('Nuovo messaggio di contatto - ' . $hotelName);
        });
    }
}