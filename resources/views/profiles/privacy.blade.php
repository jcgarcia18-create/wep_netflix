<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacidad y Términos - Cinemas Aguilas Uas</title>
    @vite('resources/css/privacy.css')
</head>
<body class="{{ session('dark_mode', true) ? 'dark-mode' : 'light-mode' }}">
    
    <header class="privacy-header">
        <div class="logo">Cinemas<span>AguilasUas</span></div>
        <nav class="header-nav">
            <a href="{{ route('home') }}" class="nav-link">Inicio</a>
        </nav>
    </header>

    <main class="privacy-content">
        <div class="privacy-container">
            
            <!-- Aviso importante -->
            <div class="disclaimer-banner">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <div class="disclaimer-text">
                    <strong>Aviso Importante:</strong> Este proyecto es un MVP con fines académicos/demostrativos y no está afiliado ni relacionado con HBO, Netflix, Paramount ni con ninguna empresa de streaming comercial.
                </div>
            </div>

            <h1 class="privacy-title">Privacidad y Términos</h1>

            <!-- Términos y Condiciones -->
            <section class="privacy-section">
                <h2 class="section-title">Términos y Condiciones</h2>
                
                <div class="content-block">
                    <p class="intro-text">
                        Esta plataforma es un producto en desarrollo (MVP) creado con fines de prueba y demostración.
                        Al acceder y utilizar el servicio, aceptas estos términos.
                    </p>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Uso del servicio</h3>
                    <p>
                        El usuario se compromete a utilizar la plataforma únicamente con fines personales y no comerciales.
                    </p>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Cuenta de usuario</h3>
                    <p>
                        El usuario es responsable de mantener la confidencialidad de su cuenta y contraseña, 
                        así como de todas las actividades realizadas desde ella.
                    </p>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Contenido</h3>
                    <p>
                        El contenido mostrado en la plataforma es de carácter demostrativo y no representa 
                        contenido oficial ni con derechos comerciales reales.
                    </p>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Disponibilidad del servicio</h3>
                    <p>
                        El servicio puede presentar interrupciones, errores o cambios sin previo aviso 
                        debido a su naturaleza experimental.
                    </p>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Modificaciones</h3>
                    <p>
                        Nos reservamos el derecho de modificar estos términos en cualquier momento.
                    </p>
                </div>
            </section>

            <!-- Política de Privacidad -->
            <section class="privacy-section">
                <h2 class="section-title">Política de Privacidad</h2>
                
                <div class="content-block">
                    <p class="intro-text">
                        Esta plataforma recopila información básica del usuario con el único fin de permitir 
                        el funcionamiento del sistema.
                    </p>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Datos recopilados</h3>
                    <ul class="data-list">
                        <li>Nombre de usuario</li>
                        <li>Correo electrónico</li>
                        <li>Datos de acceso (login)</li>
                    </ul>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Uso de la información</h3>
                    <p>La información se utiliza exclusivamente para:</p>
                    <ul class="data-list">
                        <li>Autenticación de usuarios</li>
                        <li>Pruebas de funcionalidad</li>
                        <li>Mejora del sistema</li>
                    </ul>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Protección de datos</h3>
                    <p>
                        Los datos no son compartidos con terceros y se almacenan de forma básica para fines de desarrollo.
                    </p>
                </div>

                <div class="content-block">
                    <h3 class="subsection-title">Carácter experimental</h3>
                    <p>
                        Al tratarse de un MVP, no se garantiza un nivel de seguridad equivalente a sistemas 
                        comerciales en producción.
                    </p>
                </div>
            </section>

            <!-- Contacto -->
            <section class="privacy-section contact-section">
                <h2 class="section-title">Contacto</h2>
                <div class="content-block">
                    <p>
                        Si tienes preguntas sobre estos términos o la política de privacidad, 
                        puedes contactarnos a través de la Universidad Autónoma de Sinaloa.
                    </p>
                </div>
            </section>

            <div class="back-link">
                <a href="{{ route('home') }}" class="btn-back">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M19 12H5M5 12l7 7M5 12l7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Volver al inicio
                </a>
            </div>

        </div>
    </main>

    <footer class="privacy-footer">
        <p>© 2025 Cinemas Aguilas Uas | Universidad Autónoma de Sinaloa</p>
        <p class="footer-disclaimer">Proyecto MVP con fines académicos y demostrativos</p>
    </footer>

</body>
</html>
