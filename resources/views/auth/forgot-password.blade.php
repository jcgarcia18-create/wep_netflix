<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Recuperar Contraseña</title>
    @vite('resources/css/register.css')
</head>
<body>
    <main>
        <div class="register-container">
            <div class="register-title">🔐 Recupera tu Contraseña</div>

            <p style="color: #bbb; text-align: center; margin-bottom: 1.5rem; font-size: 0.95rem; line-height: 1.5;">
                No te preocupes. Ingresa tu correo electrónico y te enviaremos un código para recuperar tu acceso.
            </p>

            {{-- Mensaje de estado --}}
            @if (session('status'))
                <div style="background-color: #2d5a2d; border-left: 4px solid #4caf50; color: #4caf50; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                {{-- Email --}}
                <label for="email" class="register-label">Correo Electrónico</label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    placeholder="tu@email.com"
                    class="register-input" 
                />
                @error('email')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                <button type="submit" class="register-btn" style="margin-bottom: 1rem;">
                    Enviar Código
                </button>

                {{-- Enlace de regreso --}}
                <a href="{{ route('login') }}" class="register-link" style="display: block; text-align: center;">
                    ← Regresar a Iniciar Sesión
                </a>
            </form>
        </div>
    </main>
</body>
</html>
