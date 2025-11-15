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
            \Log::error('ContactForm: Store failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'invio del messaggio. Riprova più tardi.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Send contact form email
     */
    private function sendContactEmail($data)
    {
        try {
            $settings = Setting::getGroupedSettings();
            $hotelName = $settings['general']['hotel_name'] ?? 'Hotel Mellow';
            $contactEmail = $settings['general']['contact_email'] ?? 'ivanturturiello@gmail.com';

            \Log::info('ContactForm: Attempting to send email', [
                'contact_email' => $contactEmail,
                'hotel_name' => $hotelName,
                'mail_mailer' => config('mail.default'),
                'mail_host' => config('mail.mailers.smtp.host'),
            ]);

            // Use MAIL_FROM_ADDRESS as sender (must be authorized by SMTP server)
            $fromEmail = env('MAIL_FROM_ADDRESS', config('mail.from.address', 'noreply@example.com'));
            $fromName = $hotelName;
            
            Mail::send('emails.contact-notification', [
                'data' => $data,
                'hotelName' => $hotelName,
                'settings' => $settings
            ], function ($message) use ($data, $hotelName, $contactEmail, $fromEmail, $fromName) {
                $message->from($fromEmail, $fromName)
                    ->to($contactEmail)
                    ->subject('Nuovo messaggio di contatto - ' . $hotelName);
            });
            
            \Log::info('ContactForm: Email sent successfully', [
                'to' => $contactEmail,
                'from' => $fromEmail
            ]);
            
        } catch (\Exception $e) {
            \Log::error('ContactForm: Email sending failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}