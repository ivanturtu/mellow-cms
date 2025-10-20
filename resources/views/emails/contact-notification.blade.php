<!DOCTYPE html>
<html>
<head>
    <title>Nuovo Messaggio di Contatto</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; }
        .container { max-width: 600px; margin: 20px auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .header { background-color: #667eea; color: #ffffff; padding: 10px 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .content { padding: 20px; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.8em; color: #777; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .message-content { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Nuovo Messaggio di Contatto per {{ $hotelName }}</h2>
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
