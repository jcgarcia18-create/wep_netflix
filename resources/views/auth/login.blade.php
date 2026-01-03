

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Iniciar Sesión</title>
    @vite('resources/css/register.css')

</head>
<body>
    <main>
        <div class="register-container">
            <div class="register-title">Iniciar Sesión</div>

            {{-- Mensaje de estado (por ejemplo: credenciales incorrectas) --}}
            @if (session('status'))
                <div class="text-error mb-4">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <label for="email" class="register-label">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="register-input" />
                @error('email')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                {{-- Contraseña --}}
                <label for="password" class="register-label">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="register-input" />
                @error('password')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                {{-- Recordarme --}}
                <div style="margin-bottom: 1rem;">
                    <label for="remember_me" style="color: #ffe600; font-size: 0.95rem;">
                        <input id="remember_me" type="checkbox" name="remember" style="margin-right: 0.5em;">
                        Recordarme
                    </label>
                </div>

              
              

                {{-- Recuperar contraseña --}}
                @if (Route::has('password.request'))
                    <a class="register-link" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
                <div style="margin-top: 1rem;">
                                    <a href="{{ route('register') }}" class="register-link" style="color: #ffe600; text-decoration: underline; font-size: 1rem; font-weight: 500;">¿No tienes cuenta? Regístrate aquí</a>
                                </div>
                <button type="submit" class="register-btn">Comenzar ahora</button>
                
            </form>
        </div>
    </main>
</body>
</html>
