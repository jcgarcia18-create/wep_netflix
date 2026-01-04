<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajustes - Cinemas Aguilas Uas</title>
    @vite('resources/css/settings.css')
</head>
<body class="{{ session('dark_mode') ? 'dark-mode' : '' }}">
    <div class="settings-container">
        <header class="settings-header">
            <a href="{{ route('home') }}" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Volver al inicio
            </a>
            <h1>Ajustes</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="settings-content">
            <div class="settings-section">
                <div class="section-header">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 1v6m0 6v6M23 12h-6m-6 0H1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <h2>Apariencia</h2>
                </div>

                <form action="{{ route('settings.toggle-dark-mode') }}" method="POST" class="settings-form">
                    @csrf
                    
                    <div class="setting-item">
                        <div class="setting-info">
                            <h3>Modo Oscuro</h3>
                            <p>Activa o desactiva el tema oscuro de la aplicación</p>
                        </div>
                        <label class="toggle-switch">
                            <input 
                                type="checkbox" 
                                name="dark_mode" 
                                value="1" 
                                {{ session('dark_mode') ? 'checked' : '' }}
                                onchange="this.form.submit()"
                            >
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </form>

                <div class="setting-description">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 16v-4m0-4h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <p>El modo oscuro reduce el brillo de la pantalla y es más cómodo para tus ojos en ambientes con poca luz.</p>
                </div>
            </div>

            <div class="settings-preview">
                <div class="preview-card">
                    <h3>Vista previa</h3>
                    <div class="preview-content">
                        <div class="preview-header">
                            <div class="preview-logo">Cinemas<span>AguilasUas</span></div>
                        </div>
                        <div class="preview-text">
                            <p>Así se verá la interfaz con la configuración actual</p>
                        </div>
                        <div class="preview-movies">
                            <div class="preview-movie"></div>
                            <div class="preview-movie"></div>
                            <div class="preview-movie"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Animación suave al cambiar el modo
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.querySelector('input[name="dark_mode"]');
            if (toggle) {
                toggle.addEventListener('change', function() {
                    document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
                });
            }
        });
    </script>
</body>
</html>
