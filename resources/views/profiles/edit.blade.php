<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - Cinemas Aguilas Uas</title>
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
            <h1>Editar perfil</h1>
        </header>

        <div class="profile-form-container">
            <form action="{{ route('user-profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data" class="profile-form">
                @csrf
                @method('PUT')
                
                <div class="form-preview">
                    <div class="preview-avatar" id="previewAvatar">
                        <img src="{{ $profile->avatar_url }}" alt="{{ $profile->nombre_perfil }}" id="avatarImg">
                        @if($profile->es_niño)
                            <span class="kids-badge">NIÑOS</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="nombre_perfil">Nombre del perfil</label>
                    <input 
                        type="text" 
                        id="nombre_perfil" 
                        name="nombre_perfil" 
                        class="form-control @error('nombre_perfil') is-invalid @enderror" 
                        value="{{ old('nombre_perfil', $profile->nombre_perfil) }}" 
                        required 
                        maxlength="50"
                        placeholder="Ej: Juan, María, etc."
                    >
                    @error('nombre_perfil')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="avatar_file">Cambiar foto de perfil</label>
                    <div class="file-upload-container">
                        <input 
                            type="file" 
                            id="avatar_file" 
                            name="avatar_file" 
                            class="file-input @error('avatar_file') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/jpg,image/gif"
                        >
                        <label for="avatar_file" class="file-upload-label">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M17 8l-5-5-5 5M12 3v12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span id="fileName">Seleccionar nueva imagen</span>
                        </label>
                    </div>
                    <small class="form-hint">Formatos: JPG, PNG, GIF (máx. 2MB). Deja vacío para mantener la imagen actual.</small>
                    @error('avatar_file')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="es_niño" 
                            id="es_niño"
                            {{ old('es_niño', $profile->es_niño) ? 'checked' : '' }}
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
                        Guardar cambios
                    </button>
                    <a href="{{ route('user-profiles.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview de imagen subida
        const avatarFileInput = document.getElementById('avatar_file');
        const avatarImg = document.getElementById('avatarImg');
        const fileNameSpan = document.getElementById('fileName');

        avatarFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Actualizar nombre del archivo
                fileNameSpan.textContent = file.name;
                
                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarImg.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                fileNameSpan.textContent = 'Seleccionar nueva imagen';
            }
        });
    </script>
</body>
</html>
