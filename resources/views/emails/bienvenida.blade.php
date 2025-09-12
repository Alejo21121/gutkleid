<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a GutKleid</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .email-header .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-content {
            padding: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #444;
        }
        .message-box {
            background-color: #f8f9fa;
            border-left: 4px solid #4b6cb7;
            padding: 15px;
            margin: 25px 0;
            text-align: center;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #27ae60;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .email-footer {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .email-footer a {
            color: #4b6cb7;
            text-decoration: none;
        }
        @media screen and (max-width: 600px) {
            .email-container { margin: 0; border-radius: 0; }
            .email-content { padding: 20px; }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="logo">GutKleid</div>
            <h1>¡Bienvenido a GutKleid!</h1>
        </div>
        <div class="email-content">
            <p class="greeting">Hola {{ $nombre }},</p>
            <div class="message-box">
                <p>Gracias por registrarte en <strong>GutKleid</strong>. Ahora puedes explorar nuestros productos y disfrutar de una experiencia de compras única.</p>
            </div>
        </div>
        <div class="email-footer">
            <p>© 2025 GUTKLEID. Todos los derechos reservados.</p>
            <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
            <p>Si necesitas ayuda, contacta con nosotros <a href="mailto:gutkleidbs@gmail.com">gutkleidbs@gmail.com</a>.</p>
        </div>
    </div>
</body>
</html>
