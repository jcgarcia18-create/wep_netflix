<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemas Aguilas Uas - Home</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @php $urls = $peliculas->pluck('video_url', 'id'); @endphp
    <script>
        window.dashboardPlaybackLogRoute = "{{ route('playback.log') }}";
    window.peliculaUrls = JSON.parse('{!! addslashes(json_encode($urls)) !!}');
    </script>
    <script src="{{ asset('js/dashboard.js') }}" defer></script>
</head>
<body class="{{ session('dark_mode', true) ? 'dark-mode' : 'light-mode' }}">

    <header class="header">
    
        <div class="logo">Cinemas<span>AguilasUas</span></div>
        <nav>
            <ul class="menu">
                <li><a href="#seguir-viendo">Seguir Viendo</a></li>
                <li><a href="#accion">Acción</a></li>
                <li><a href="#terror">Terror</a></li>
                <li><a href="#comedia">Comedia</a></li>
                <li><a href="#drama">Drama</a></li>
                <li><a href="#ciencia-ficcion">Ciencia Ficción</a></li>
            </ul>
        </nav>
        <div class="user-options">
            <div class="profile-dropdown">
                <button class="profile-btn" id="profileMenuBtn">
                    @if($activeProfile)
                        <img src="{{ $activeProfile->avatar_url }}" alt="{{ $activeProfile->nombre_perfil }}" class="profile-avatar-small">
                        <span>{{ $activeProfile->nombre_perfil }}</span>
                        @if($activeProfile->es_niño)
                            <span class="kids-badge-small">NIÑOS</span>
                        @endif
                    @else
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" fill="currentColor"/>
                            <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20V21H4V20Z" fill="currentColor"/>
                        </svg>
                        <span>{{ Auth::user()->name }}</span>
                    @endif
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </button>
                <div class="profile-menu" id="profileMenu">
                    <a href="{{ route('profiles.index') }}" class="profile-menu-item profile-switch-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Cambiar de perfil
                    </a>
                    <div class="profile-menu-divider"></div>
                    <a href="{{ route('user-profiles.index') }}" class="profile-menu-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
                            <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20V21H4V20Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Administra los perfiles
                    </a>
                    <a href="{{ route('settings.index') }}" class="profile-menu-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                            <path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Ajustes
                    </a>
                    <a href="#" class="profile-menu-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
                        </svg>
                        Cuenta
                    </a>
                    <a href="#" class="profile-menu-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="7" width="20" height="15" rx="2" stroke="currentColor" stroke-width="2"/>
                            <path d="M16 7V5a4 4 0 00-8 0v2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Suscripción
                    </a>
                    <a href="#" class="profile-menu-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Privacidad y Términos
                    </a>
                    <a href="#" class="profile-menu-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 16v-4m0-4h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Ayuda
                    </a>
                    <div class="profile-menu-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="profile-menu-item logout-item">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>



    <main class="content">
       
        @php
            // Obtener todos los géneros únicos, aunque estén en campos con múltiples géneros separados por coma
            $allGenres = collect();
            foreach ($peliculas as $pelicula) {
                $genres = array_map('trim', explode(',', $pelicula->genre));
                foreach ($genres as $g) {
                    $allGenres->push($g);
                }
            }
            $uniqueGenres = $allGenres->unique()->sort();
        @endphp

    
        @if ($peliculasSeguirViendo->count() > 0)
            <section class="movie-section" id="seguir-viendo">
                <h2 class="section-title">Seguir Viendo</h2>
                <div class="movie-carousel">
                    <div class="movie-scroll">
                        
                        @foreach ($peliculasSeguirViendo as $pelicula)
                            <div class="movie-card">
                                <a href="#" onclick="openMovieTab('{{ json_encode($pelicula) }}')">
                                    <img src="{{ $pelicula->poster_url }}" alt="{{ $pelicula->title }}">
                                </a>
                                <div class="movie-info">
                                    <h3>{{ $pelicula->title }}</h3>
                                    <p style="font-size:0.9rem; margin-bottom:0.5rem;">{{ $pelicula->genre }} · {{ $pelicula->duration_minutes }} min</p>
                                    <div class="movie-actions">
                                          <a href="javascript:void(0)" 
                                                                  class="btn-play" 
                                                                  onclick="logView('{{ $pelicula->id }}', '{{ $pelicula->video_url }}')">
                                                                  ▶ Reproducir
                                                              </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                </div>
            </section>
        @endif

            @foreach ($uniqueGenres as $genero)
            <section class="movie-section" id="{{ Str::slug($genero) }}">
                <h2 class="section-title">{{ $genero }}</h2>
                <div class="movie-carousel">
                    <div class="movie-scroll">
                        @foreach ($peliculas as $pelicula)
                            @php
                                $genres = array_map('trim', explode(',', $pelicula->genre));
                            @endphp
                            @if (in_array($genero, $genres))
                                <div class="movie-card">
                                    <a href="#" onclick="openMovieTab('{{ json_encode($pelicula) }}')">
                                        <img src="{{ $pelicula->poster_url }}" alt="{{ $pelicula->title }}">
                                    </a>
                                    <div class="movie-info">
                                        <h3>{{ $pelicula->title }}</h3>
                                        <p style="font-size:0.9rem; margin-bottom:0.5rem;">{{ $pelicula->genre }} · {{ $pelicula->duration_minutes }} min</p>
                                        <div class="movie-actions">
                                                <a href="javascript:void(0)" 
                                                                 class="btn-play" 
                                                                 onclick="logView('{{ $pelicula->id }}', '{{ $pelicula->video_url }}')">
                                                                 ▶ Reproducir
                                                             </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
           @endforeach
    </main>

    <footer>
        <p>© 2025 Cinemas Aguilas Uas | Universidad Autónoma de Sinaloa</p>
    </footer>


</body>
</html>
