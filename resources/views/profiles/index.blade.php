<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Perfiles - Cinemas Aguilas Uas</title>
    <link rel="stylesheet" href="{{ asset('css/profiles-admin.css') }}">
</head>
<body>
    <div class="profiles-container">
        <header class="profiles-header">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Volver al inicio
            </a>
            <h1>Administrar perfiles</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="profiles-grid">
            @foreach($profiles as $profile)
                <div class="profile-card">
                    <div class="profile-avatar">
                        <img src="{{ $profile->avatar_url }}" alt="{{ $profile->nombre_perfil }}">
                        @if($profile->es_niño)
                            <span class="kids-badge">NIÑOS</span>
                        @endif
                    </div>
                    <h3 class="profile-name">{{ $profile->nombre_perfil }}</h3>
                    <div class="profile-actions">
                        <a href="{{ route('user-profiles.edit', $profile->id) }}" class="btn btn-edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Editar
                        </a>
                        <form action="{{ route('user-profiles.destroy', $profile->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este perfil?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            @if($profiles->count() < 5)
                <div class="profile-card add-profile">
                    <a href="{{ route('user-profiles.create') }}" class="add-profile-btn">
                        <div class="add-icon">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3>Agregar perfil</h3>
                    </a>
                </div>
            @endif
        </div>

        <div class="profiles-info">
            <p>Tienes {{ $profiles->count() }} de 5 perfiles disponibles</p>
        </div>
    </div>
</body>
</html>
