<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayuda - Manual de Usuario</title>
    @vite('resources/css/ayuda.css')
</head>
<body>
    <div class="container">
        <a href="/home" class="back-link">← Volver al inicio</a>
        
        <div class="header">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path d="M12 16v-4m0-4h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <h1>Ayuda - Manual de Usuario</h1>
        </div>

        <ul>
            <li><strong>Agregar un perfil:</strong> Ve a la sección de perfiles, haz clic en "Agregar perfil", ingresa los datos y guarda.</li>
            <li><strong>Eliminar un perfil:</strong> Selecciona el perfil, haz clic en el ícono de eliminar (🗑️) y confirma.</li>
            <li><strong>Cambiar la imagen de un perfil:</strong> Selecciona el perfil, haz clic en "Editar imagen" y guarda los cambios.</li>
            <li><strong>Crear un perfil para niños:</strong> Al agregar/editar perfil, selecciona "Perfil para niños".</li>
            <li><strong>Buscar una película por nombre:</strong> Usa la barra de búsqueda en la sección de películas.</li>
            <li><strong>Agregar una película a favoritos:</strong> Haz clic en el ícono de "Favorito" (⭐) en la película.</li>
            <li><strong>Quitar una película de favoritos:</strong> Ve a favoritos y haz clic en "Quitar" (❌).</li>
            <li><strong>Cambiar de perfil:</strong> Haz clic en tu avatar/nombre y selecciona otro perfil.</li>
            <li><strong>Navegar entre secciones:</strong> Usa el menú principal para ir al inicio, películas, favoritos, ajustes y ayuda.</li>
        </ul>

        <div class="footer-note">
            Si tienes dudas, busca el ícono de ayuda (?) en la aplicación.
        </div>
    </div>
</body>
</html>
