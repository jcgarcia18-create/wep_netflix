<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo - Cinema Águilas UAS</title>
    @vite('resources/css/catalog.css')
</head>
<body>

    <header class="catalog-header">
         <div class="logo">Cinemas<span>AguilasUas</span></div>
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1>Catálogo de películas</h1>
                <p>Explora nuestra selección</p>
            </div>
            <div>
                <a href="/login" class="btn btn-primary" style="margin-right: 10px;">Iniciar Sesión</a>
                <a href="/register" class="btn btn-secondary">Registrarse</a>
            </div>
        </div>
    </header>

    <main class="container catalog-grid">
        @foreach ($peliculas as $pelicula)
            <article class="card">
                <div class="card-thumb">
                    <img src="{{ $pelicula->poster_url ?? '/images/placeholder-300x450.png' }}" alt="Poster de {{ $pelicula->title ?? 'Sin título' }}" class="card-img" />
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $pelicula->title ?? 'Sin título' }}</h3>
                    <p class="card-desc">{{ $pelicula->description ?? 'Sin descripción.' }}</p>
                </div>
            </article>
        @endforeach
    </main>
</body>
</html>