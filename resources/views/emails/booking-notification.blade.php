<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuova Richiesta di Prenotazione</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .booking-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏨 Nuova Richiesta di Prenotazione</h1>
        <p>{{ $hotelName }}</p>
    </div>
    
    <div class="content">
        <h2>Dettagli della Richiesta</h2>
        
        <div class="booking-details">
            <div class="detail-row">
                <span class="label">📅 Check-in:</span>
                <span class="value">{{ $bookingRequest->checkin_date->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">📅 Check-out:</span>
                <span class="value">{{ $bookingRequest->checkout_date->format('d/m/Y') }}</span>
            </div>
            <div class="detail-row">
                <span class="label">🏠 Camere:</span>
                <span class="value">{{ $bookingRequest->rooms }}</span>
            </div>
            <div class="detail-row">
                <span class="label">👥 Ospiti:</span>
                <span class="value">{{ $bookingRequest->guests }}</span>
            </div>
            @if($bookingRequest->name)
            <div class="detail-row">
                <span class="label">👤 Nome:</span>
                <span class="value">{{ $bookingRequest->name }}</span>
            </div>
            @endif
            @if($bookingRequest->email)
            <div class="detail-row">
                <span class="label">📧 Email:</span>
                <span class="value">{{ $bookingRequest->email }}</span>
            </div>
            @endif
            @if($bookingRequest->phone)
            <div class="detail-row">
                <span class="label">📞 Telefono:</span>
                <span class="value">{{ $bookingRequest->phone }}</span>
            </div>
            @endif
            @if($bookingRequest->message)
            <div class="detail-row">
                <span class="label">💬 Messaggio:</span>
                <span class="value">{{ $bookingRequest->message }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="label">⏰ Data richiesta:</span>
                <span class="value">{{ $bookingRequest->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        
        <div class="footer">
            <p>Questa email è stata generata automaticamente dal sistema di prenotazioni.</p>
            <p>ID Richiesta: #{{ $bookingRequest->id }}</p>
        </div>
    </div>
</body>
</html>
