<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago exitoso - Cinema Águilas</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <style>
        body {
            background: #232635;
            min-height: 100vh;
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stripe-container {
            width: 80vw;
            max-width: 800px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0,0,0,0.15);
            padding: 3rem 2rem;
            text-align: center;
            margin: auto;
        }
        .stripe-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            color: #27ae60;
        }
        .stripe-text {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #232635;
        }
        .btn-stripe {
            width: 100%;
            padding: 0.75rem;
            font-size: 1.1rem;
            border-radius: 8px;
            background: #27ae60;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-stripe:hover {
            background: #219150;
        }
    </style>
</head>
<body>
    <div class="stripe-container">
        <h2 class="stripe-title">¡Pago exitoso!</h2>
        <p class="stripe-text">Tu suscripción ha sido activada. ¡Disfruta de todo el contenido premium!</p>
        <a href="{{ route('home') }}" class="btn-stripe">Ir al Inicio</a>
    </div>
</body>
</html>
