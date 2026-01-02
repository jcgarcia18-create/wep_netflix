<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Nueva Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <main>
        <div class="register-container">
            <div class="register-title">🔑 Nueva Contraseña</div>

            <p style="color: #bbb; text-align: center; margin-bottom: 1.5rem; font-size: 0.95rem; line-height: 1.5;">
                Establece una nueva contraseña segura para tu cuenta.
            </p>

            {{-- Mensaje de estado --}}
            @if (session('status'))
                <div style="background-color: #2d5a2d; border-left: 4px solid #4caf50; color: #4caf50; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem;">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errores --}}
            @if ($errors->any())
                <div style="background-color: #5a2d2d; border-left: 4px solid #ff6b6b; color: #ff6b6b; padding: 12px; border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="code" value="{{ $code }}">

                {{-- Nueva Contraseña --}}
                <label for="password" class="register-label">Nueva Contraseña</label>
                <input 
                    id="password" 
                    type="password" 
                    name="password" 
                    placeholder="Mínimo 8 caracteres"
                    required 
                    autofocus
                    class="register-input" 
                />
                @error('password')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                {{-- Confirmar Contraseña --}}
                <label for="password_confirmation" class="register-label">Confirmar Contraseña</label>
                <input 
                    id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    placeholder="Repite tu contraseña"
                    required
                    class="register-input" 
                />
                @error('password_confirmation')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                <button type="submit" class="register-btn" style="margin-bottom: 1rem;">
                    Guardar Nueva Contraseña
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
