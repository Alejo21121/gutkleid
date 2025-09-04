<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Recuperación</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333333;
            line-height: 1.6;
        }
        
        /* Contenedor principal */
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        /* Encabezado */
        .email-header {
            background: linear-gradient(135deg, #4b6cb7 0%, #182848 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        
        /* Contenido */
        .email-content {
            padding: 30px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #444444;
        }
        
        .code-container {
            background-color: #f8f9fa;
            border-left: 4px solid #4b6cb7;
            padding: 15px;
            margin: 25px 0;
            text-align: center;
        }
        
        .verification-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 3px;
            color: #182848;
            padding: 10px;
            margin: 15px 0;
            background-color: #ffffff;
            border-radius: 5px;
            display: inline-block;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .instructions {
            margin-bottom: 25px;
            color: #555555;
        }
        
        /* Pie de página */
        .email-footer {
            background-color: #f0f0f0;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
        }
        
        .email-footer a {
            color: #4b6cb7;
            text-decoration: none;
        }
        
        .warning {
            background-color: #fff4f4;
            border: 1px solid #ffdfdf;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
            font-size: 12px;
            color: #cc0000;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
            color: white;
        }
        
        /* Responsive */
        @media screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-content {
                padding: 20px;
            }
            
            .verification-code {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="logo">GutKleid</div>
            <h1>Recuperación de Contraseña</h1>
        </div>
        
        <div class="email-content">
            <p class="greeting">Hola,</p>
            
            <p>Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Utiliza el siguiente código de verificación para completar el proceso:</p>
            
            <div class="code-container">
                <p>Tu código de verificación es:</p>
                <div class="verification-code">{{ $token }}</div>
                <p>Este código expirará en 15 minutos por razones de seguridad.</p>
            </div>
            
            <p class="instructions">Ingresa este código en la página de recuperación de contraseña para crear una nueva contraseña para tu cuenta.</p>
            
            <div class="warning">
                <strong>Importante:</strong> Si no has solicitado restablecer tu contraseña, ignora este mensaje o contacta con nuestro soporte si crees que se trata de un error.
            </div>
        </div>
        
        <div class="email-footer">
            <p>© 2025 GUTKLEID. Todos los derechos reservados.</p>
            <p>Este es un mensaje automático, por favor no respondas a este correo.</p>
            <p>Si necesitas ayuda, contacta con nosotros <a href="#">gutkleidbs@gmail.com</a>.</p>
        </div>
    </div>
</body>
</html>