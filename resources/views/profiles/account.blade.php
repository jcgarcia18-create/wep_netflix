<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta - Cinemas Aguilas Uas</title>
    @vite('resources/css/account.css')
</head>
<body class="{{ session('dark_mode', true) ? 'dark-mode' : 'light-mode' }}">
    
    <header class="account-header">
        <div class="logo">Cinemas<span>AguilasUas</span></div>
        <nav class="header-nav">
            <a href="{{ route('home') }}" class="nav-link">Inicio</a>
        </nav>
        <div class="user-info">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="8" r="4" fill="currentColor"/>
                <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20V21H4V20Z" fill="currentColor"/>
            </svg>
        </div>
    </header>

    <main class="account-content">
        <div class="account-container">
            <h1 class="account-title">Cuenta</h1>

            <section class="account-section">
                <h2 class="section-title">Detalles de la cuenta</h2>
                
                <div class="account-item">
                    <div class="item-content">
                        <label class="item-label">Correo electrónico</label>
                        <div class="item-value">{{ Auth::user()->email }}</div>
                    </div>
                    <button class="edit-btn" onclick="openEditModal('email')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <div class="account-item">
                    <div class="item-content">
                        <label class="item-label">Contraseña</label>
                        <div class="item-value">••••••••••</div>
                    </div>
                    <button class="edit-btn" onclick="openEditModal('password')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

                <div class="account-item">
                    <div class="item-content">
                        <label class="item-label">Nombre</label>
                        <div class="item-value">{{ Auth::user()->name }}</div>
                    </div>
                    <button class="edit-btn" onclick="openEditModal('name')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>

            </section>

            @if(Auth::user()->suscripcion_activa)
            <section class="account-section">
                <h2 class="section-title">Suscripción</h2>
                
                <div class="subscription-card">
                    <div class="subscription-status active">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <polyline points="22 4 12 14.01 9 11.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Suscripción Activa</span>
                    </div>
                    <div class="subscription-details">
                        <p>Tu suscripción está activa</p>
                        @if(Auth::user()->suscripcion_expira)
                        <p class="expiration-date">Expira: {{ Auth::user()->suscripcion_expira->format('d/m/Y') }}</p>
                        @endif
                    </div>
                </div>
            </section>
            @else
            <section class="account-section">
                <h2 class="section-title">Suscripción</h2>
                
                <div class="subscription-card inactive">
                    <div class="subscription-status inactive">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                            <line x1="15" y1="9" x2="9" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <line x1="9" y1="9" x2="15" y2="15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        <span>Sin Suscripción Activa</span>
                    </div>
                    <div class="subscription-details">
                        <p>Actualmente no tienes una suscripción activa</p>
                        <a href="{{ route('subscription') }}" class="subscribe-btn">Suscribirse ahora</a>
                    </div>
                </div>
            </section>
            @endif
        </div>
    </main>

    <!-- Modal para editar -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Editar</h2>
                <button class="close-btn" onclick="closeEditModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" action="{{ route('account.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="field" id="editField">
                    <div id="formContent"></div>
                    <div class="modal-actions">
                        <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancelar</button>
                        <button type="submit" class="btn-save">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(field) {
            const modal = document.getElementById('editModal');
            const modalTitle = document.getElementById('modalTitle');
            const editField = document.getElementById('editField');
            const formContent = document.getElementById('formContent');
            
            editField.value = field;
            
            let content = '';
            
            switch(field) {
                case 'email':
                    modalTitle.textContent = 'Cambiar correo electrónico';
                    content = `
                        <div class="form-group">
                            <label for="email">Nuevo correo electrónico</label>
                            <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="current_password">Contraseña actual</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                    `;
                    break;
                case 'password':
                    modalTitle.textContent = 'Cambiar contraseña';
                    content = `
                        <div class="form-group">
                            <label for="current_password">Contraseña actual</label>
                            <input type="password" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">Nueva contraseña</label>
                            <input type="password" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">Confirmar nueva contraseña</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                    `;
                    break;
                case 'name':
                    modalTitle.textContent = 'Cambiar nombre';
                    content = `
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                    `;
                    break;
            }
            
            formContent.innerHTML = content;
            modal.style.display = 'flex';
        }
        
        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.style.display = 'none';
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeEditModal();
            }
        }
    </script>
</body>
</html>
