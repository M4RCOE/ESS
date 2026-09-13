<?php

use App\Session;

$session = Session::getUser();

use function Francerz\Http\Utils\baseUrl;
use function Francerz\Http\Utils\siteUrl;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- ============================================
         THEME INITIALIZER (evita FOUC)
         ============================================ -->
    <style>
        html.theme-loading {
            visibility: hidden;
        }
    </style>
    <script>
        document.documentElement.classList.add('theme-loading');

        (function() {
            try {
                const saved = localStorage.getItem('darkMode');
                const prefers = window.matchMedia('(prefers-color-scheme: dark)').matches;
                const isDark = saved !== null ? saved === 'true' : prefers;
                document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
            } catch (e) {
                document.documentElement.setAttribute('data-bs-theme', 'light');
            }
        })();
    </script>

    <!-- ============================================
         META
         ============================================ -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="description" content="<?= htmlspecialchars($description ?? 'ESS Colima — Economía Social y Sostenible') ?>">
    <meta name="theme-color" content="#3a6cae">

    <title><?= htmlspecialchars($title ?? 'ESS Colima') ?></title>

    <link rel="preconnect" href="https://randomuser.me">

    <!-- ============================================
         ESTILOS
         ============================================ -->

    <!-- 1. Bootstrap -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/bootstrap/bootstrap.min.css') ?>">

    <!-- 2. FontAwesome -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/fontawesome/css/all.min.css') ?>">
    <link rel="preload" href="<?= baseUrl('./assets/vendor/fontawesome/webfonts/fa-solid-900.woff2') ?>" as="font" type="font/woff2" crossorigin>

    <!-- 3. DataTables -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/datatables/jquery.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/datatables/responsive.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/datatables/buttons.dataTables.min.css') ?>">

    <!-- 4. Alertas -->
    <link rel="stylesheet" href="<?= baseUrl('/assets/sweetalert2/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?= baseUrl('/assets/iziToast/iziToast.min.css') ?>">

    <!-- 5. Estilo personalizado -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/style.css') ?>">
</head>

<body>

    <!-- ============================================
         NAVBAR
         ============================================ -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center">
                <button class="btn d-lg-none me-2 b-0" id="sidebarToggle" aria-label="Abrir menú">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
                <h1 class="fs-3 fw-bold d-flex align-items-center m-0">
                    <i class="fas fa-leaf me-2 text-success"></i>
                    ESS Colima
                </h1>
            </div>

            <div class="ms-auto d-flex align-items-center gap-2">

                <!-- ============================================
         NOTIFICACIONES
         ============================================ -->
                <div class="dropdown">
                    <a class="btn-icon nav-icon-btn position-relative"
                        href="#"
                        role="button"
                        id="notifDropdown"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="outside"
                        aria-expanded="false"
                        aria-haspopup="true"
                        aria-label="Notificaciones"
                        title="Notificaciones">

                        <i class="fas fa-bell"></i>

                        <!-- Badge con pulso -->
                        <span class="notif-dot" aria-hidden="true"></span>
                        <span class="notif-count">3</span>
                    </a>

                    <ul class="dropdown-menu menu-nav dropdown-menu-end notif-menu"
                        aria-labelledby="notifDropdown">

                        <!-- Header del dropdown -->
                        <li class="notif-header">
                            <div class="d-flex align-items-center justify-content-between">
                                <span>Notificaciones</span>
                                <span class="badge badge-accent">3 nuevas</span>
                            </div>
                        </li>

                        <!-- Items -->
                        <li>
                            <a class="dropdown-item notif-item" href="#">
                                <div class="notif-icon notif-icon-blue">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="notif-content">
                                    <p class="notif-title">Nuevo mensaje</p>
                                    <small class="notif-time">
                                        <i class="far fa-clock"></i> Hace 5 min
                                    </small>
                                </div>
                                <span class="notif-unread" aria-hidden="true"></span>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item notif-item" href="#">
                                <div class="notif-icon notif-icon-green">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="notif-content">
                                    <p class="notif-title">Tarea completada</p>
                                    <small class="notif-time">
                                        <i class="far fa-clock"></i> Hace 1 hora
                                    </small>
                                </div>
                                <span class="notif-unread" aria-hidden="true"></span>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item notif-item" href="#">
                                <div class="notif-icon notif-icon-amber">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div class="notif-content">
                                    <p class="notif-title">Alerta del sistema</p>
                                    <small class="notif-time">
                                        <i class="far fa-clock"></i> Hace 3 horas
                                    </small>
                                </div>
                            </a>
                        </li>

                        <!-- Footer -->
                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>
                        <li>
                            <a class="dropdown-item notif-footer text-center" href="#">
                                <i class="fas fa-inbox me-2"></i> Ver todas
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- ============================================
         USUARIO
         ============================================ -->
                <div class="dropdown">
                    <a class="user-dropdown d-flex align-items-center gap-2"
                        href="#"
                        role="button"
                        id="userDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        aria-haspopup="true"
                        aria-label="Menú de usuario">

                        <div class="avatar-wrapper">
                            <img src="https://randomuser.me/api/portraits/men/10.jpg"
                                class="avatar-img"
                                alt="<?= $session->nombre_completo ?>"
                                width="40"
                                height="40"
                                loading="lazy">
                            <span class="avatar-online" aria-hidden="true"></span>
                        </div>

                        <div class="d-none d-sm-block user-info">
                            <span class="user-name"><?= ucwords($session->nombre_completo) ?></span>
                            <span class="user-role"><?= ucwords($session->perfil) ?></span>
                        </div>

                        <i class="fas fa-chevron-down user-chevron d-none d-sm-inline"></i>
                    </a>

                    <ul class="dropdown-menu menu-nav dropdown-menu-end user-menu"
                        aria-labelledby="userDropdown">

                        <!-- Header con info del usuario -->
                        <li class="user-menu-header">
                            <div class="d-flex align-items-center gap-3">
                                <img src="https://randomuser.me/api/portraits/men/10.jpg"
                                    class="rounded-circle"
                                    alt=""
                                    width="44"
                                    height="44">
                                <div class="overflow-hidden">
                                    <p class="mb-0 fw-semibold text-truncate">John Doe</p>
                                    <small class="text-muted text-truncate d-block">
                                        john.doe@esscolima.mx
                                    </small>
                                </div>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>

                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user"></i>
                                <span>Mi perfil</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-key"></i>
                                <span>Cambiar contraseña</span>
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider my-2">
                        </li>

                        <li>
                            <a class="dropdown-item dropdown-item-danger"
                                href="<?= siteUrl('/logOut') ?>"
                                onclick="return confirmarCerrarSesion(event)">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Cerrar sesión</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- ============================================
         OVERLAY
         ============================================ -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- ============================================
         SIDEBAR
         ============================================ -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-content">

            <!-- ============================================
                 OPERACIONES
                 ============================================ -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">
                    <i class="fas fa-bolt"></i>
                    <span>Operaciones</span>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link active" href="#">
                            <i class="fas fa-home"></i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Pedidos</span>
                            <span class="nav-count">12</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-box"></i>
                            <span>Productos</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ============================================
                 CATÁLOGOS
                 ============================================ -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">
                    <i class="fas fa-folder-tree"></i>
                    <span>Catálogos</span>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-tags"></i>
                            <span>Tipos de producto</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-ruler"></i>
                            <span>Unidades de medida</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-credit-card"></i>
                            <span>Tipos de pago</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ============================================
                 PROVEEDORES
                 ============================================ -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">
                    <i class="fas fa-truck"></i>
                    <span>Proveedores</span>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-industry"></i>
                            <span>Proveedores</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-tag"></i>
                            <span>Tipos de proveedor</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Ubicaciones</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ============================================
                 REPORTES
                 ============================================ -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-file-invoice"></i>
                            <span>Ventas y pedidos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-file-alt"></i>
                            <span>Reportes ESS</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- ============================================
                 SEGURIDAD
                 ============================================ -->
            <div class="sidebar-section">
                <div class="sidebar-section-title">
                    <i class="fas fa-shield-halved"></i>
                    <span>Seguridad</span>
                </div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-users"></i>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-user-shield"></i>
                            <span>Roles y perfiles</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-key"></i>
                            <span>Permisos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sidebar-link ess-link" href="#">
                            <i class="fas fa-cog"></i>
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Footer del sidebar: toggle tema -->
        <div class="sidebar-footer">
            <a id="darkModeToggleItem" class="nav-link sidebar-link ess-link d-flex align-items-center" href="#" role="button" aria-label="Cambiar tema">
                <i id="darkModeIcon" class="fas fa-moon me-2"></i>
                <span>Cambiar tema</span>
                <div class="ms-auto form-check form-switch m-0 d-none">
                    <input class="form-check-input" type="checkbox" id="darkModeSwitch" onclick="event.stopPropagation();">
                </div>
            </a>
        </div>
    </div>

    <!-- ============================================
         CONTENIDO PRINCIPAL
         ============================================ -->
    <div class="main-content" id="mainContent">
        <?= $layout->section('content') ?>
    </div>

    <!-- CSS inline del chevron -->
    <style>
        .transition-transform {
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
    <script>
        /* ============================================
   CERRAR SESIÓN CON CONFIRMACIÓN
   ============================================ */
        function confirmarCerrarSesion(e) {
            e.preventDefault();

            const logoutUrl = e.currentTarget.getAttribute('href') || '/logOut';
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

            // Si no hay SweetAlert2, usar confirm nativo
            if (typeof Swal === 'undefined') {
                if (confirm('¿Cerrar sesión?')) enviarLogout(logoutUrl);
                return false;
            }

            Swal.fire({
                icon: 'warning',
                title: '¿Cerrar sesión?',
                html: `
            <p style="margin: 0; font-size: 0.9rem; opacity: 0.8;">
                Se cerrará tu sesión actual.<br>
                Tendrás que volver a ingresar tus credenciales.
            </p>
        `,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-sign-out-alt" style="margin-right:6px;"></i> Sí, salir',
                cancelButtonText: '<i class="fas fa-times" style="margin-right:6px;"></i> Cancelar',
                reverseButtons: true,
                focusCancel: true,
                buttonsStyling: false,
                customClass: {
                    popup: 'swal-logout-popup',
                    title: 'swal-logout-title',
                    htmlContainer: 'swal-logout-text',
                    icon: 'swal-logout-icon',
                    confirmButton: 'swal-logout-btn swal-logout-btn-confirm',
                    cancelButton: 'swal-logout-btn swal-logout-btn-cancel',
                    actions: 'swal-logout-actions'
                },
                background: isDark ? '#181d27' : '#ffffff',
                color: isDark ? '#e9ecf1' : '#0f172a',
                backdrop: isDark ? 'rgba(0,0,0,0.65)' : 'rgba(15,23,42,0.5)',
                showClass: {
                    popup: 'swal-logout-show'
                },
                hideClass: {
                    popup: 'swal-logout-hide'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    enviarLogout(logoutUrl);
                }
            });

            return false;
        }


        /* ============================================
           ENVÍO DEL LOGOUT (POST)
           ============================================ */
        function enviarLogout(url) {
            // Toast de despedida
            if (typeof iziToast !== 'undefined') {
                iziToast.info({
                    title: 'Cerrando sesión',
                    message: 'Hasta pronto...',
                    position: 'topRight',
                    timeout: 1500,
                    transitionIn: 'fadeInDown',
                    backgroundColor: '#eff4fb',
                    titleColor: '#234372',
                    messageColor: '#234372',
                    icon: '<i class="fas fa-hand-wave" style="color:#3a6cae;"></i>'
                });
            }

            // Pequeño delay para que se vea el toast
            setTimeout(function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';

                // CSRF token si existe
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                if (csrfMeta) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'csrf_token';
                    input.value = csrfMeta.getAttribute('content');
                    form.appendChild(input);
                }

                document.body.appendChild(form);
                form.submit();
            }, 300);
        }
    </script>
    <!-- ============================================
         SCRIPTS — ORDEN CRÍTICO
         ============================================ -->

    <!-- 1. jQuery -->
    <script src="<?= baseUrl('./assets/vendor/jquery/jquery.min.js') ?>"></script>

    <!-- 2. Bootstrap -->
    <script src="<?= baseUrl('./assets/vendor/bootstrap/bootstrap.bundle.min.js') ?>"></script>

    <!-- 3. DataTables Core -->
    <script src="<?= baseUrl('./assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/dataTables.responsive.min.js') ?>"></script>

    <!-- 4. DataTables Buttons -->
    <script src="<?= baseUrl('./assets/vendor/datatables/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/jszip.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/pdfmake.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/vfs_fonts.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/buttons.html5.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/buttons.print.min.js') ?>"></script>

    <!-- 5. ApexCharts -->
    <script src="<?= baseUrl('./assets/vendor/apexcharts/apexcharts.min.js') ?>"></script>

    <!-- 6. SweetAlert2 -->
    <script src="<?= baseUrl('/assets/sweetalert2/sweetalert2.all.min.js') ?>"></script>

    <!-- 7. iziToast -->
    <script src="<?= baseUrl('/assets/iziToast/iziToast.min.js') ?>"></script>

    <!-- 8. App principal -->
    <script src="<?= baseUrl('./assets/script.js') ?>"></script>

    <!-- 9. Gráficos -->
    <script src="<?= baseUrl('./assets/chartDashboard.js') ?>"></script>

    <!-- 10. Scripts por página -->
    <?= $layout->section('scripts') ?>

    <!-- 11. Quitar theme-loading -->
    <script>
        document.documentElement.classList.remove('theme-loading');
    </script>

    <noscript>
        <div style="position:fixed;inset:0;background:#fff;color:#000;z-index:99999;display:flex;align-items:center;justify-content:center;font-family:sans-serif;padding:2rem;text-align:center;">
            <div>
                <h1>JavaScript desactivado</h1>
                <p>Esta aplicación requiere JavaScript para funcionar correctamente.</p>
            </div>
        </div>
    </noscript>

</body>

</html>
