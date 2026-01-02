<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Validar Código</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <main>
        <div class="register-container">
            <div class="register-title">✅ Verifica tu Código</div>

            <p style="color: #bbb; text-align: center; margin-bottom: 1.5rem; font-size: 0.95rem; line-height: 1.5;">
                Hemos enviado un código de 6 dígitos a <strong style="color: #ffe600;">{{ request('email') }}</strong>. Ingrésalo para continuar.
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

            <form method="POST" action="{{ route('password.verify-code') }}">
                @csrf
                <input type="hidden" name="email" value="{{ request('email') }}">

                {{-- Código --}}
                <label for="code" class="register-label">Código de 6 Dígitos</label>
                <input 
                    id="code" 
                    type="text" 
                    name="code" 
                    maxlength="6"
                    inputmode="numeric"
                    placeholder="000000"
                    required 
                    autofocus
                    class="register-input" 
                    style="text-align: center; font-size: 1.5rem; letter-spacing: 0.5rem;"
                />
                @error('code')
                    <div class="text-error">{{ $message }}</div>
                @enderror

                <button type="submit" class="register-btn" style="margin-bottom: 1rem;">
                    Validar Código
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
