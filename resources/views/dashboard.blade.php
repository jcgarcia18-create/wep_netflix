<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinemas Aguilas Uas - Home</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ai-search.css') }}">
    
    <script>
        window.dashboardPlaybackLogRoute = "{{ route('playback.log') }}";
        window.peliculaUrls = @json($peliculas->pluck('video_url', 'id'));
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
            </ul>
        </nav>
        
        <div class="search-trigger-container">
            <button class="btn-search-ia-trigger" onclick="openSearchModal()">
                <span>✨</span> Buscador IA
            </button>
        </div>

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
                        <span>{{ Auth::user()->name }}</span>
                    @endif
                    <svg class="arrow-icon" width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 4L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                </button>
                
                <div class="profile-menu" id="profileMenu">
                    <a href="{{ route('profiles.index') }}" class="profile-menu-item">Cambiar de perfil</a>
                    <a href="{{ route('settings.index') }}" class="profile-menu-item">Ajustes</a>
                    <div class="profile-menu-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="profile-menu-item logout-item">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="content">
        
        <div id="seccion-resultados-ia" style="display: none; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h2 class="section-title">Resultados de Inteligencia Artificial</h2>
                <button onclick="cerrarResultadosIA()" style="background: transparent; border: 1px solid #aaa; color: white; padding: 5px 15px; border-radius: 4px; cursor: pointer;">✕ Volver al catálogo</button>
            </div>
            <div id="grid-resultados" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;"></div>
        </div>

        <div id="catalogo-original">
            
            @php
                $peliculasPorGenero = [];
                foreach ($peliculas as $pelicula) {
                    $generos = explode(',', $pelicula->genre);
                    foreach ($generos as $g) {
                        $nombreGenero = trim($g);
                        if (!empty($nombreGenero)) {
                            $peliculasPorGenero[$nombreGenero][] = $pelicula;
                        }
                    }
                }
                ksort($peliculasPorGenero);
            @endphp

            @if ($peliculasSeguirViendo->count() > 0)
                <section class="movie-section" id="seguir-viendo">
                    <h2 class="section-title">Seguir Viendo</h2>
                    <div class="movie-carousel">
                        <div class="movie-scroll">
                            @foreach ($peliculasSeguirViendo as $pelicula)
                                <div class="movie-card">
                                    <a href="#" onclick='openMovieTab(@json($pelicula))'>
                                        <img src="{{ $pelicula->poster_url }}" alt="{{ $pelicula->title }}">
                                    </a>
                                    <div class="movie-info">
                                        <h3>{{ $pelicula->title }}</h3>
                                        <p style="font-size:0.9rem;">{{ $pelicula->genre }}</p>
                                        <div class="movie-actions">
                                            <a href="javascript:void(0)" class="btn-play" onclick="logView('{{ $pelicula->id }}', '{{ $pelicula->video_url }}')">▶ Reproducir</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @foreach ($peliculasPorGenero as $nombreGenero => $listaPeliculas)
                <section class="movie-section" id="{{ Str::slug($nombreGenero) }}">
                    <h2 class="section-title">{{ $nombreGenero }}</h2>
                    <div class="movie-carousel">
                        <div class="movie-scroll">
                            @foreach ($listaPeliculas as $pelicula)
                                <div class="movie-card">
                                    <a href="#" onclick='openMovieTab(@json($pelicula))'>
                                        <img src="{{ $pelicula->poster_url }}" alt="{{ $pelicula->title }}">
                                    </a>
                                    <div class="movie-info">
                                        <h3>{{ $pelicula->title }}</h3>
                                        <p style="font-size:0.9rem;">{{ $pelicula->genre }}</p>
                                        <div class="movie-actions">
                                            <a href="javascript:void(0)" class="btn-play" onclick="logView('{{ $pelicula->id }}', '{{ $pelicula->video_url }}')">▶ Reproducir</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endforeach
        </div>
    </main>

    <footer>
        <p>© 2025 Cinemas Aguilas Uas | Universidad Autónoma de Sinaloa</p>
    </footer>

    <div id="aiSearchModal" class="ai-modal-overlay">
        <div class="ai-modal-content">
            <button class="ai-modal-close" onclick="closeSearchModal()">✕</button>
            <h2 class="ai-modal-title">¿No recuerdas el nombre?</h2>
            <p class="ai-modal-subtitle">Describe la película y nuestra IA la encontrará por ti.</p>
            
            <div class="ai-search-input-group">
                <input type="text" id="aiSearchInput" placeholder="Ej: Película de barcos que se hunden..." autocomplete="off">
                <button class="ai-search-btn" onclick="buscarPeliculasIA()">Buscar</button>
            </div>
        </div>
    </div>

    <script>
        function openSearchModal() {
            const modal = document.getElementById('aiSearchModal');
            modal.style.display = 'flex';
            document.getElementById('aiSearchInput').focus();
        }

        function closeSearchModal() {
            document.getElementById('aiSearchModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('aiSearchModal');
            if (event.target == modal) {
                closeSearchModal();
            }
        }

        async function buscarPeliculasIA() {
            const input = document.getElementById('aiSearchInput');
            const query = input.value.trim();
            const contenedorIA = document.getElementById('seccion-resultados-ia');
            const catalogoNormal = document.getElementById('catalogo-original');
            const grid = document.getElementById('grid-resultados');
            
            if (!query) return;

            closeSearchModal();
            catalogoNormal.style.display = 'none';
            contenedorIA.style.display = 'block';
            grid.innerHTML = '<p style="color:gray; width:100%; text-align:center; padding: 50px;">Consultando a la Inteligencia Artificial...</p>';

            try {
                const response = await fetch(`/api/peliculas?ai_search=${encodeURIComponent(query)}`);
                if (!response.ok) throw new Error('Error en la API');
                const peliculas = await response.json();
                grid.innerHTML = ''; 

                if (peliculas.length === 0) {
                    grid.innerHTML = '<p style="text-align:center; width:100%; padding: 50px;">No se encontraron coincidencias.</p>';
                    return;
                }

                peliculas.forEach(peli => {
                    const peliString = JSON.stringify(peli).replace(/"/g, '&quot;');
                    
                    const card = `
                        <div class="movie-card" style="margin: 10px; width: 200px;"> 
                            <a href="#" onclick='openMovieTab(${peliString})'>
                                <img src="${peli.poster_url}" alt="${peli.title}" style="width:100%; border-radius:8px;">
                            </a>
                            <div class="movie-info">
                                <h3>${peli.title}</h3>
                                <p>${peli.genre}</p>
                            </div>
                        </div>
                    `;
                    grid.innerHTML += card;
                });

            } catch (error) {
                console.error(error);
                grid.innerHTML = '<p style="color:red; text-align:center;">Error de conexión con el cerebro IA.</p>';
            }
        }

        function cerrarResultadosIA() {
            document.getElementById('aiSearchInput').value = '';
            document.getElementById('seccion-resultados-ia').style.display = 'none';
            document.getElementById('catalogo-original').style.display = 'block';
        }

        document.getElementById('aiSearchInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') buscarPeliculasIA();
        });
    </script>

</body>
</html>