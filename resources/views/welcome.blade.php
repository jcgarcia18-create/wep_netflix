<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Águilas UAS</title>
    @vite('resources/css/welcome.css')
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">Cinemas<span>AguilasUas</span></div>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Registrarse</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h2 class="subtitle">Tu cine en casa, fácil y rápido</h2>
                <h1 class="title">Disfruta de tus películas y series favoritas en cualquier dispositivo</h1>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn btn-primary">Comenzar ahora</a>
                    <a href="{{ route('catalog') }}" class="btn btn-secondary">Ver catálogo</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
