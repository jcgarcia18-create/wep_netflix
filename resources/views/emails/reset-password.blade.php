<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background-color: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 32px; font-weight: bold; color: #e50914; }
        .content { line-height: 1.6; color: #333; }
        .button { display: inline-block; background-color: #e50914; color: white; padding: 12px 30px; text-decoration: none; border-radius: 4px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
        .warning { background-color: #fff3cd; padding: 10px; border-radius: 4px; margin: 15px 0; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Netflix</div>
        </div>

        <div class="content">
            <h2>Recupera tu contraseña</h2>
            
            <p>Hola,</p>
            
            <p>Recibimos una solicitud para recuperar tu contraseña. Haz clic en el botón de abajo para crear una nueva contraseña:</p>
            
            <a href="{{ $resetLink }}" class="button">Recuperar Contraseña</a>
            
            <p>O copia y pega este enlace en tu navegador:</p>
            <p><small>{{ $resetLink }}</small></p>
            
            <div class="warning">
                <strong>Nota de seguridad:</strong> Este enlace expirará en 60 minutos. Si no solicitaste este correo, ignóralo o contacta a nuestro equipo de soporte.
            </div>
            
            <p>
                Si tienes problemas para hacer clic en el botón, copia y pega el enlace anterior en tu navegador.
            </p>
        </div>

        <div class="footer">
            <p>© {{ date('Y') }} Netflix. Todos los derechos reservados.</p>
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</body>
</html>
