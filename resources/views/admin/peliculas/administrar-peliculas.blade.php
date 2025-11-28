<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Administrar Películas</title>
    
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="{{ asset('css/catalog.css') }}">
</head>
<body style="background-color: #111827;"> 
    <nav class="admin-sidebar">
        <h2>Admin Netflix</h2>
        <hr style="border-color: #4b5563; margin: 15px 0;">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.peliculas.index') }}" style="background-color: #e11d48; color: white;">Administrar Películas</a>
        <a href="{{ route('admin.users.index') }}">Administrar Usuarios</a>
        <form method="POST" action="{{ route('logout') }}"> @csrf <button type="submit">Cerrar Sesión</button> </form>
    </nav>

    <main class="admin-content">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="color: white; font-size: 1.8rem; font-weight: bold;">Administrar Películas</h1>
            <a href="javascript:void(0)" onclick="openCreateModal()" class="admin-btn-primary">Añadir Nueva Película</a>
        </div>
        
        <div class="catalog-grid"> 
            @foreach ($peliculas as $pelicula)
                <article class="card"> 
                    <div class="card-thumb" style="background-image: url('{{ $pelicula->poster_url }}')"></div> 
                    <div class="card-body"> 
                        <h3 class="card-title">{{ $pelicula->title }}</h3> 
                        <p class="card-meta">{{ $pelicula->genre }} · {{ $pelicula->duration_minutes }}m</p> 
                        
                        <div class="card-actions-admin"> 
                            <a href="javascript:void(0)" onclick="openEditModal('{{ $pelicula->id }}')" class="admin-btn-secondary">Modificar</a>
                            
                            <form action="{{ route('admin.peliculas.destroy', $pelicula->id) }}" method="POST" onsubmit="return confirm('¿Seguro?');">
                                @csrf
                                @method('DELETE') 
                                <button type="submit" class="admin-btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div id="edit-modal-container" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
            <div id="modal-content">
                <button onclick="closeModal()" class="close-button">&times;</button>
                <div id="error-messages" style="color: red; margin-bottom: 10px;"></div>
                <div id="modal-body">Cargando formulario...</div>
            </div>
        </div>
    </main>
<script>
   
    function applyInputValues(containerElement) {
    
        const inputElements = containerElement.querySelectorAll('input[data-value], textarea');
        
        inputElements.forEach(input => {
           
            if (input.dataset.value) {
                input.value = input.dataset.value;
            }
            
            
        });
    }

    function openEditModal(peliculaId) {
        const modalContainer = document.getElementById('edit-modal-container');
        const modalBody = document.getElementById('modal-body');

        modalContainer.style.display = 'flex';
        modalBody.innerHTML = 'Cargando...';

        fetch(`/admin/peliculas/${peliculaId}/edit`)
            .then(response => {
                if (!response.ok) throw new Error('Respuesta de red no válida');
                return response.text();
            })
            .then(html => {
                
                modalBody.innerHTML = html;
                document.getElementById('modal-content').querySelector('.close-button').onclick = closeModal;
                
              
                applyInputValues(modalBody); 

            })
            .catch(error => {
                modalBody.innerHTML = 'Error al cargar el formulario.';
                console.error('Error al cargar la edición:', error);
            });
    }

    function closeModal() {
        document.getElementById('edit-modal-container').style.display = 'none';
        
        document.getElementById('modal-body').innerHTML = 'Cargando formulario...'; 
        document.getElementById('error-messages').innerHTML = '';
    }

function openCreateModal() {
    const modalContainer = document.getElementById('edit-modal-container');
    const modalBody = document.getElementById('modal-body');
    const errorMessages = document.getElementById('error-messages');

    modalContainer.style.display = 'flex';
    modalBody.innerHTML = 'Cargando...';
    errorMessages.innerHTML = '';


    fetch('{{ route('admin.peliculas.create') }}')
        .then(response => {
            if (!response.ok) throw new Error('Respuesta de red no válida: ' + response.status);
            return response.text();
        })
        .then(html => {
          
            modalBody.innerHTML = html;
            
        
            const form = modalBody.querySelector('#peliculaForm');
            if (form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    
                    const formData = new FormData(form);
                    
                    fetch('{{ route('admin.peliculas.store') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            }

     
            document.getElementById('modal-content').querySelector('.close-button').onclick = closeModal;
            
         
            applyInputValues(modalBody); 

        })
        .catch(error => {
            modalBody.innerHTML = `Error al cargar. Revisa los logs. (${error.message})`;
            console.error('Error al cargar la edición:', error);
        });
}
</script>
</body>
</html>