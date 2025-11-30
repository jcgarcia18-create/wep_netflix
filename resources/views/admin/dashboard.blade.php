<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    
    @vite('resources/css/app.css')

</head>
<body class="admin-body">

    <nav class="admin-sidebar">
        <h2>Admin Netflix</h2>
        <hr style="border-color: #4b5563; margin: 15px 0;">
        
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        
        <a href="{{ route('admin.peliculas.index') }}">Administrar Películas</a>
        
        <a href="{{ route('admin.users.index') }}">Administrar Usuarios</a> <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Cerrar Sesión</button>
        </form>
    </nav>

    <main class="admin-content">
        
        <h1>Dashboard de Administrador</h1>
        <p style="margin-top: 10px; font-size: 1.1rem;">
            ¡Bienvenido, {{ auth()->user()->name }}!
        </p>
        
        <div style="margin-top: 30px; background: #1f2937; padding: 20px; border-radius: 8px;">
            <p>Desde aquí puedes administrar el sitio.</p>
        </div>

    </main>

</body>
</html>