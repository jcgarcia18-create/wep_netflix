<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Roboto', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #00103d 0%, #1a1a2e 100%);
            padding: 20px;
        }
        .container { 
            max-width: 650px; 
            margin: 0 auto; 
            background-color: rgba(50, 50, 70, 0.95);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 16, 61, 0.5);
            border: 1px solid rgba(255, 230, 0, 0.1);
        }
        .header { 
            background: linear-gradient(135deg, #00103d 0%, #1a3a5c 100%);
            padding: 50px 20px;
            text-align: center;
            border-bottom: 3px solid #ffe600;
        }
        .logo { 
            font-size: 48px; 
            font-weight: bold; 
            color: #ffe600;
            letter-spacing: 3px;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(255, 230, 0, 0.3);
        }
        .subtitle {
            color: #b3b3cc;
            font-size: 14px;
            letter-spacing: 1px;
        }
        .content { 
            padding: 50px 40px;
            line-height: 1.8;
            color: #d0d0e0;
        }
        .content h2 {
            color: #ffe600;
            font-size: 28px;
            margin-bottom: 25px;
            text-align: center;
            text-shadow: 0 2px 5px rgba(255, 230, 0, 0.2);
        }
        .greeting {
            color: #e0e0f0;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .message {
            color: #b3b3cc;
            font-size: 15px;
            margin-bottom: 30px;
            text-align: center;
            line-height: 1.6;
        }
        .code-box {
            background: linear-gradient(135deg, rgba(255, 230, 0, 0.05) 0%, rgba(255, 230, 0, 0.02) 100%);
            border: 2px solid #ffe600;
            padding: 30px;
            margin: 35px 0;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(255, 230, 0, 0.1);
        }
        .code-label {
            color: #ffe600;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        .code-box .code {
            font-size: 48px;
            font-weight: bold;
            color: #ffe600;
            letter-spacing: 12px;
            font-family: 'Courier New', monospace;
            text-shadow: 0 2px 10px rgba(255, 230, 0, 0.2);
        }
        .expiration {
            color: #ff9999;
            font-size: 13px;
            margin-top: 15px;
            font-weight: 600;
        }
        .info-box {
            background-color: rgba(255, 230, 0, 0.08);
            border-left: 4px solid #ffe600;
            padding: 20px;
            margin: 30px 0;
            border-radius: 6px;
            font-size: 14px;
            color: #c0c0d5;
            line-height: 1.6;
        }
        .info-box strong {
            color: #ffe600;
        }
        .icon {
            font-size: 20px;
            margin-right: 8px;
        }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #ffe600, transparent);
            margin: 25px 0;
            opacity: 0.3;
        }
        .footer { 
            text-align: center; 
            padding: 30px 40px;
            border-top: 1px solid rgba(255, 230, 0, 0.1);
            font-size: 12px; 
            color: #8a8a9d;
        }
        .footer p {
            margin: 6px 0;
        }
        .footer-brand {
            color: #ffe600;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .social-note {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 230, 0, 0.1);
            font-size: 11px;
            color: #7a7a8d;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎬 CINEMA UAS</div>
            <div class="subtitle">Recuperación de Acceso</div>
        </div>

        <div class="content">
            <h2>Recupera tu Contraseña</h2>
            
            <p class="greeting">¡Hola!</p>
            
            <p class="message">
                Recibimos una solicitud para recuperar tu contraseña. Utiliza el código de 6 dígitos que se muestra a continuación para establecer una nueva contraseña.
            </p>

            <div class="code-box">
                <div class="code-label">Tu Código de Recuperación</div>
                <div class="code">{{ $resetLink }}</div>
                <div class="expiration">⏱️ Válido por 15 minutos</div>
            </div>

            <div class="divider"></div>

            <div class="info-box">
                <strong><span class="icon">🔒</span>Seguridad:</strong> Nunca compartir este código con nadie. El equipo de Cinema UAS nunca te pedirá tu código de recuperación por mensaje o llamada.
            </div>

            <p class="message" style="margin-top: 25px; color: #d0d0e0;">
                Si no solicitaste este cambio de contraseña, puedes ignorar este correo de forma segura.
            </p>
        </div>

        <div class="footer">
            <div class="footer-brand">🎬 CINEMA UAS - Plataforma de Películas</div>
            <p>© {{ date('Y') }} Cinema UAS. Todos los derechos reservados.</p>
            <p>Este es un correo automático. Por favor, no respondas a este mensaje.</p>
            <div class="social-note">
                Mantén tu cuenta segura: Nunca compartas tus datos de acceso. Usa contraseñas fuertes y únicas.
            </div>
        </div>
    </div>
</body>
</html> 
            color: #888;
        }
        .footer p {
            margin: 5px 0;
        }
        .divider {
            height: 1px;
            background-color: #333;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🎬 Netflix</div>
        </div>

        <div class="content">
            <h2>¡Recupera tu contraseña!</h2>
            
            <p>¡Hola!</p>
            
            <p>Recibimos una solicitud para recuperar tu contraseña de Netflix. Tu código de recuperación es:</p>
            
            <div class="code-box">
                <div class="code">{{ $resetLink }}</div>
                <div class="label">Código de 6 dígitos</div>
            </div>

            <p style="text-align: center; color: #ffe600; font-weight: 600;">Este código expira en 15 minutos</p>

            <div class="divider"></div>

            <div class="info-box">
                <strong>⚠️ Nota de seguridad:</strong> Nunca compartir este código con nadie. Netflix nunca te pedirá que compartas tu código. Si no solicitaste esta recuperación, puedes ignorar este correo.
            </div>

            <p style="text-align: center; margin-top: 30px;">
                <strong>¿Necesitas ayuda?</strong> Contacta a nuestro <strong style="color: #ffe600;">equipo de soporte</strong>
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Netflix, Inc. Todos los derechos reservados.</p>
            <p>Este es un correo automático. Por favor, no respondas a este mensaje.</p>
            <p style="margin-top: 15px; font-size: 11px; color: #666;">Cuenta segura: Netflix utiliza encriptación para proteger tu información.</p>
        </div>
    </div>
</body>
</html>
