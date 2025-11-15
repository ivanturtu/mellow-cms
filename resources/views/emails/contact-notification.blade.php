<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Messaggio di Contatto</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f4f4f4; 
            color: #333; 
            line-height: 1.6;
        }
        .container { 
            max-width: 600px; 
            margin: 20px auto; 
            background-color: #fff; 
            border-radius: 8px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            overflow: hidden;
        }
        .header { 
            background: linear-gradient(135deg, #d8cbb8 0%, #c4b5a0 50%, #b8a892 100%);
            color: #353535; 
            padding: 30px 20px; 
            text-align: center; 
        }
        .header-logo {
            max-height: 80px;
            max-width: 200px;
            margin-bottom: 15px;
        }
        .header h2 {
            color: #353535;
            margin: 0;
            font-size: 22px;
        }
        .content { 
            padding: 30px 20px; 
            background: #f8f9fa;
        }
        .footer { 
            text-align: center; 
            margin-top: 20px; 
            padding: 20px;
            font-size: 0.8em; 
            color: #777; 
            border-top: 1px solid #ddd;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td { 
            border: 1px solid #eee; 
            padding: 12px; 
            text-align: left; 
        }
        th { 
            background-color: #f8f9fa; 
            font-weight: 600;
            color: #555;
        }
        .message-content { 
            background-color: #f9f9f9; 
            padding: 15px; 
            border-radius: 5px; 
            margin-top: 10px; 
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @php
                $logo = \App\Models\Setting::where('group', 'general')->where('key', 'logo')->first();
                if ($logo && $logo->value) {
                    $logoPath = str_starts_with($logo->value, 'mellow/') 
                        ? url($logo->value) 
                        : url('storage/' . $logo->value);
                } else {
                    $logoPath = url('mellow/images/main-logo.png');
                }
            @endphp
            @if($logoPath)
                <img src="{{ $logoPath }}" alt="{{ $hotelName }}" class="header-logo">
            @endif
            <h2>Nuovo Messaggio di Contatto</h2>
            <p style="margin: 10px 0 0 0; color: #555; font-size: 16px;">{{ $hotelName }}</p>
        </div>
        <div class="content">
            <p>Gentile Amministratore,</p>
            <p>Hai ricevuto un nuovo messaggio di contatto tramite il sito web. Di seguito i dettagli:</p>
            
            <table>
                <tr>
                    <th>Campo</th>
                    <th>Dettaglio</th>
                </tr>
                <tr>
                    <td><strong>Nome</strong></td>
                    <td>{{ $data['name'] }}</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>{{ $data['email'] }}</td>
                </tr>
                @if($data['phone'])
                <tr>
                    <td><strong>Telefono</strong></td>
                    <td>{{ $data['phone'] }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Oggetto</strong></td>
                    <td>{{ $data['subject'] }}</td>
                </tr>
                <tr>
                    <td><strong>Messaggio</strong></td>
                    <td>
                        <div class="message-content">
                            {{ $data['message'] }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><strong>Data Invio</strong></td>
                    <td>{{ now()->format('d/m/Y H:i') }}</td>
                </tr>
            </table>

            <p>Si prega di rispondere al messaggio il prima possibile.</p>
            <p>Cordiali saluti,</p>
            <p>Il tuo sistema di contatti</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ $hotelName }}. Tutti i diritti riservati.</p>
        </div>
    </div>
</body>
</html>
