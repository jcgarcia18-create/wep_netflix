@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex items-center mb-6">
        <svg class="w-8 h-8 text-blue-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.227 9a3.001 3.001 0 015.546 0c0 1.657-1.343 3-3 3s-3-1.343-3-3zm3 7v.01"></path>
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
        </svg>
        <h1 class="text-2xl font-bold text-gray-800">Ayuda - Manual de Usuario</h1>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <ul class="space-y-4 text-gray-700">
            <li><strong>Agregar un perfil:</strong> Ve a la sección de perfiles, haz clic en “Agregar perfil”, ingresa los datos y guarda.</li>
            <li><strong>Eliminar un perfil:</strong> Selecciona el perfil, haz clic en el ícono de eliminar (🗑️) y confirma.</li>
            <li><strong>Cambiar la imagen de un perfil:</strong> Selecciona el perfil, haz clic en “Editar imagen” y guarda los cambios.</li>
            <li><strong>Crear un perfil para niños:</strong> Al agregar/editar perfil, selecciona “Perfil para niños”.</li>
            <li><strong>Buscar una película por nombre:</strong> Usa la barra de búsqueda en la sección de películas.</li>
            <li><strong>Agregar una película a favoritos:</strong> Haz clic en el ícono de “Favorito” (⭐) en la película.</li>
            <li><strong>Quitar una película de favoritos:</strong> Ve a favoritos y haz clic en “Quitar” (❌).</li>
            <li><strong>Cambiar de perfil:</strong> Haz clic en tu avatar/nombre y selecciona otro perfil.</li>
            <li><strong>Navegar entre secciones:</strong> Usa el menú principal para ir al dashboard, películas, favoritos, ajustes y ayuda.</li>
        </ul>
        <div class="mt-6 text-gray-600 text-sm">Si tienes dudas, busca el ícono de ayuda (?) en la aplicación.</div>
    </div>
</div>
@endsection
