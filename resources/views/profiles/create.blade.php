<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Perfil - Cinemas Aguilas Uas</title>
    <link rel="stylesheet" href="{{ asset('css/profiles-admin.css') }}">
</head>
<body>
    <div class="profiles-container">
        <header class="profiles-header">
            <a href="{{ route('user-profiles.index') }}" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Volver
            </a>
            <h1>Agregar perfil</h1>
        </header>

        <div class="profile-form-container">
            <form action="{{ route('user-profiles.store') }}" method="POST" class="profile-form">
                @csrf
                
                <div class="form-preview">
                    <div class="preview-avatar" id="previewAvatar">
                        <img src="https://ui-avatars.com/api/?name=Usuario&background=FFD700&color=001F3F&size=200" alt="Avatar" id="avatarImg">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre_perfil">Nombre del perfil</label>
                    <input 
                        type="text" 
                        id="nombre_perfil" 
                        name="nombre_perfil" 
                        class="form-control @error('nombre_perfil') is-invalid @enderror" 
                        value="{{ old('nombre_perfil') }}" 
                        required 
                        maxlength="50"
                        placeholder="Ej: Juan, María, etc."
                    >
                    @error('nombre_perfil')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="avatar_url">URL del Avatar (opcional)</label>
                    <input 
                        type="url" 
                        id="avatar_url" 
                        name="avatar_url" 
                        class="form-control @error('avatar_url') is-invalid @enderror" 
                        value="{{ old('avatar_url') }}"
                        placeholder="https://ejemplo.com/imagen.jpg"
                    >
                    <small class="form-hint">Deja en blanco para usar un avatar automático</small>
                    @error('avatar_url')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="es_niño" 
                            id="es_niño"
                            {{ old('es_niño') ? 'checked' : '' }}
                        >
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-text">Perfil para niños</span>
                    </label>
                    <small class="form-hint">Los perfiles para niños solo mostrarán contenido apropiado</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Crear perfil
                    </button>
                    <a href="{{ route('user-profiles.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Actualizar preview del avatar en tiempo real
        const nombreInput = document.getElementById('nombre_perfil');
        const avatarUrlInput = document.getElementById('avatar_url');
        const avatarImg = document.getElementById('avatarImg');

        function updateAvatar() {
            const avatarUrl = avatarUrlInput.value;
            const nombre = nombreInput.value || 'Usuario';
            
            if (avatarUrl) {
                avatarImg.src = avatarUrl;
            } else {
                avatarImg.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(nombre)}&background=FFD700&color=001F3F&size=200`;
            }
        }

        nombreInput.addEventListener('input', updateAvatar);
        avatarUrlInput.addEventListener('input', updateAvatar);
    </script>
</body>
</html>
