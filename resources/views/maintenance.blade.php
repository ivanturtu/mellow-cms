<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manutenzione in corso - {{ config('app.name', 'SuperHost CMS') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #d8cbb8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: #333;
        }
        
        .maintenance-container {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.5s ease-in;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .logo-container {
            margin-bottom: 30px;
        }
        
        .logo-container img {
            max-height: 120px;
            max-width: 300px;
            width: auto;
            height: auto;
        }
        
        .maintenance-icon {
            font-size: 40px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
        
        h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #4379c2;
            font-weight: 700;
        }
        
        p {
            font-size: 18px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 15px;
        }
        
        .maintenance-message {
            background: #f8f9fa;
            border-left: 4px solid #4379c2;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
            text-align: left;
        }
        
        .maintenance-message p {
            margin: 0;
            font-size: 16px;
            color: #555;
        }
        
        .contact-info {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #e0e0e0;
        }
        
        .contact-info p {
            font-size: 14px;
            color: #888;
        }
        
        .contact-info a {
            color: #4379c2;
            text-decoration: none;
            font-weight: 600;
        }
        
        .contact-info a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 600px) {
            .maintenance-container {
                padding: 40px 20px;
            }
            
            h1 {
                font-size: 24px;
            }
            
            p {
                font-size: 16px;
            }
            
            .maintenance-icon {
                font-size: 30px;
            }
            
            .logo-container img {
                max-height: 90px;
                max-width: 220px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        @php
            $logo = \App\Models\Setting::where('group', 'general')->where('key', 'logo')->first();
            if ($logo && $logo->value) {
                $logoPath = str_starts_with($logo->value, 'mellow/') 
                    ? asset($logo->value) 
                    : asset('storage/' . $logo->value);
            } else {
                $logoPath = asset('mellow/images/main-logo.png');
            }
            $siteName = \App\Models\Setting::where('group', 'general')->where('key', 'hotel_name')->first();
            $siteNameValue = $siteName ? $siteName->value : 'Hotel Mellow';
        @endphp
        
        @if($logoPath)
            <div class="logo-container">
                <img src="{{ $logoPath }}" alt="{{ $siteNameValue }}" class="img-fluid">
            </div>
        @endif
        
        <div class="maintenance-icon">🔧</div>
        <h1>Manutenzione in corso</h1>
        <p>Il sito è temporaneamente non disponibile per manutenzione programmata.</p>
        
        <div class="maintenance-message">
            <p>{{ \App\Models\Setting::get('maintenance_message', 'Stiamo lavorando per migliorare il sito. Torneremo presto online!') }}</p>
        </div>
        
        <div class="contact-info">
            @php
                $contactEmail = \App\Models\Setting::get('contact_email', '');
                $contactPhone = \App\Models\Setting::get('contact_phone', '');
            @endphp
            
            @if($contactEmail || $contactPhone)
                <p>Per informazioni urgenti:</p>
                @if($contactEmail)
                    <p><a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
                @endif
                @if($contactPhone)
                    <p><a href="tel:{{ $contactPhone }}">{{ $contactPhone }}</a></p>
                @endif
            @endif
        </div>
    </div>
</body>
</html>

