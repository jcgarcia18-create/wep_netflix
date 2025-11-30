<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>¿Quién está viendo? - Cinemas Aguilas Uas</title>
    @vite('resources/css/profiles.css')
</head>
<body>
    <div class="profile-selection-container">
        <div class="profile-selection-header">
            <div class="logo">Cinemas<span>AguilasUas</span></div>
        </div>

        <div class="profile-selection-content">
            <h1>¿Quién está viendo?</h1>
            
            <div class="profile-selection-grid">
                @foreach ($profiles as $profile)
                    <a href="{{ route('profiles.select', $profile->id) }}" class="profile-selection-card">
                        <div class="profile-selection-avatar">
                            <img src="{{ $profile->avatar_url }}" alt="{{ $profile->nombre_perfil }}">
                            @if($profile->es_niño)
                                <span class="kids-badge">NIÑOS</span>
                            @endif
                        </div>
                        <p class="profile-selection-name">{{ $profile->nombre_perfil }}</p>
                    </a>
                @endforeach
                
                @if($profiles->count() < 5)
                    <a href="{{ route('profiles.create') }}" class="profile-selection-card add-profile-card">
                        <div class="profile-selection-avatar add-avatar">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="profile-selection-name">Agregar perfil</p>
                    </a>
                @endif
            </div>

            <a href="{{ route('user-profiles.index') }}" class="manage-profiles-link">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                    <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" stroke="currentColor" stroke-width="2"/>
                </svg>
                Administrar perfiles
            </a>
        </div>
    </div>
</body>
</html>