<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\Newsletter\Newsletter;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{
    protected $newsletter;

    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Subscribe to newsletter
     */
    public function subscribe(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ]);

        try {
            $email = $request->email;
            $mergeFields = [];

            if ($request->first_name) {
                $mergeFields['FNAME'] = $request->first_name;
            }

            if ($request->last_name) {
                $mergeFields['LNAME'] = $request->last_name;
            }

            // Subscribe to Mailchimp
            $result = $this->newsletter->subscribe($email, $mergeFields);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Iscrizione alla newsletter completata con successo!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore durante l\'iscrizione alla newsletter.'
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Newsletter subscription error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Errore durante l\'iscrizione alla newsletter. Riprova più tardi.'
            ], 500);
        }
    }

    /**
     * Unsubscribe from newsletter
     */
    public function unsubscribe(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            $result = $this->newsletter->unsubscribe($request->email);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Disiscrizione dalla newsletter completata con successo!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Errore durante la disiscrizione dalla newsletter.'
                ], 400);
            }

        } catch (\Exception $e) {
            Log::error('Newsletter unsubscription error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Errore durante la disiscrizione dalla newsletter. Riprova più tardi.'
            ], 500);
        }
    }

    /**
     * Check if email is subscribed
     */
    public function checkSubscription(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        try {
            $isSubscribed = $this->newsletter->isSubscribed($request->email);

            return response()->json([
                'success' => true,
                'subscribed' => $isSubscribed
            ]);

        } catch (\Exception $e) {
            Log::error('Newsletter check subscription error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Errore durante la verifica dello stato di iscrizione.'
            ], 500);
        }
    }
}
