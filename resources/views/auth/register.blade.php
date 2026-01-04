<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Crear Cuenta</title>
    @vite('resources/css/register.css')
</head>
<body>
    <main>
        <div class="register-container">
            <div class="register-title">Crear Cuenta</div>

            {{-- Mensajes de validación general (opcional) --}}
            @if (session('status'))
                <div class="text-error mb-4">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nombre --}}
                <label for="name" class="register-label">Nombre</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="register-input" />
                @error('name')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                {{-- Email --}}
                <label for="email" class="register-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="register-input" />
                @error('email')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                {{-- Contraseña --}}
                <label for="password" class="register-label">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="register-input" />
                @error('password')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                {{-- Confirmar Contraseña --}}
                <label for="password_confirmation" class="register-label">Confirmar Contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="register-input" />
                @error('password_confirmation')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                {{-- Link al login --}}
                <div style="margin-top: 1rem;">
                    <a href="{{ route('login') }}" class="register-link" style="color: #ffe600; text-decoration: underline; font-size: 1rem; font-weight: 500;">¿Ya tienes cuenta? Inicia sesión aquí</a>
                </div>

                {{-- Botón de envío --}}
                <button type="submit" class="register-btn">Registrarse</button>
            </form>
        </div>
    </main>
</body>
</html>


