<?php

use function Francerz\Http\Utils\baseUrl;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <style>
        html.theme-loading {
            visibility: hidden;
        }
    </style>
    <script>
        // Evita el flash: oculta la página y aplica el tema oscuro antes de cargar CSS
        document.documentElement.classList.add('theme-loading');

        const isDark = localStorage.getItem('darkMode') === 'true';
        document.documentElement.setAttribute('data-bs-theme', isDark ? 'dark' : 'light');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?? 'Website' ?></title>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/fontawesome/css/all.min.css') ?>">
    <link rel="preload" href="<?= baseUrl('./assets/vendor/fontawesome/webfonts/fa-solid-900.woff2') ?>" as="font" type="font/woff2" crossorigin>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/datatables/jquery.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/datatables/responsive.dataTables.min.css') ?>">
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/datatables/buttons.dataTables.min.css') ?>">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/bootstrap/bootstrap.min.css') ?>">

    <!-- Estilo personalizado -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/style.css') ?>">

    <!-- Scripts principales -->
    <script src="<?= baseUrl('./assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/apexcharts/apexcharts.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/chartDashboard.js') ?>"></script>
    <!-- <script src="<?= baseUrl('./assets/chartManager.js') ?>"></script> -->
    <script src="<?= baseUrl('./assets/script.js') ?>"></script>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center">
                <button class="btn d-lg-none me-2 b-0" id="sidebarToggle">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
                <h1 class="fs-3 fw-bold d-flex align-items-center m-0">
                    <i class="fas fa-rocket me-2 text-primary"></i>
                    Website
                </h1>
            </div>

            <div class="ms-auto d-flex align-items-center">
                <!-- Notificaciones -->
                <div class="dropdown me-3">
                    <a class="position-relative user-dropdown" href="#" data-bs-toggle="dropdown">
                        <i class="fas fa-bell text-danger"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge bg-red-500 rounded-pill notification-badge">3</span>
                    </a>
                    <ul class="dropdown-menu menu-nav dropdown-menu-end">
                        <li>
                            <h6 class="dropdown-header px-3 pt-2 pb-1">Notificaciones</h6>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                <div class="bg-blue-100 text-blue-500 rounded p-2 me-2"><i class="fas fa-envelope"></i></div>
                                <div>
                                    <p class="mb-0">Nuevo mensaje</p>
                                    <small class="text-muted">Hace 5 min</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2" href="#">
                                <div class="bg-green-100 text-green-500 rounded p-2 me-2"><i class="fas fa-check-circle"></i></div>
                                <div>
                                    <p class="mb-0">Tarea completada</p>
                                    <small class="text-muted">Hace 1 hora</small>
                                </div>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-1">
                        </li>
                        <li><a class="dropdown-item text-center text-primary py-2" href="#">Ver todas</a></li>
                    </ul>
                </div>

                <!-- Usuario -->
                <div class="dropdown">
                    <a class="d-flex align-items-center dropdown-toggle user-dropdown text-decoration-none" href="#" data-bs-toggle="dropdown">
                        <img src="https://randomuser.me/api/portraits/men/10.jpg" class="rounded-circle me-2" alt="user" style="width: 48px;">
                        <div class="d-none d-sm-block">
                            <span class="d-block">John Doe</span>
                            <small class="text-muted d-block">Administrador</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu menu-nav dropdown-menu-end">
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="fas fa-user me-2 text-gray-500"></i>Perfil</a></li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="fas fa-cog me-2 text-gray-500"></i>Configuración</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item d-flex align-items-center" href="#"><i class="fas fa-sign-out-alt me-2 text-gray-500"></i>Cerrar sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3">
            <div class="px-3 py-2 mb-3">
                <h5 class="text-gray-600 font-semibold mb-0">MENÚ PRINCIPAL</h5>
            </div>

            <ul class="nav flex-column">
                <li class="nav-item mt-1"><a class="nav-link sidebar-link active" href="#"><i class="me-3 fas fa-home"></i>Inicio</a></li>
                <li class="nav-item mt-1"><a class="nav-link sidebar-link" href="#"><i class="me-3 fas fa-chart-line"></i>Dashboard</a></li>
                <li class="nav-item mt-1"><a class="nav-link sidebar-link" href="#"><i class="me-3 fas fa-users"></i>Usuarios</a></li>
                <li class="nav-item mt-1"><a class="nav-link sidebar-link" href="#"><i class="me-3 fas fa-box"></i>Productos</a></li>
                <li class="nav-item mt-1"><a class="nav-link sidebar-link" href="#"><i class="me-3 fas fa-file-invoice"></i>Facturas</a></li>
                <li class="nav-item mt-1"><a class="nav-link sidebar-link" href="#"><i class="me-3 fas fa-cog"></i>Configuración</a></li>
            </ul>

            <div class="mt-4">
                <a class="d-flex align-items-center dropdown-toggle text-gray-600 text-decoration-none px-3 py-2" data-bs-toggle="collapse" href="#submenu">
                    <i class="me-3 fas fa-layer-group me-2"></i>Más Opciones
                </a>
                <div class="collapse show" id="submenu">
                    <ul class="nav flex-column ps-4 mt-1">
                        <li class="nav-item mt-1"><a class="nav-link sidebar-link" href="#"><i class="me-3 fas fa-circle-notch fa-xs me-2"></i>Opción 1</a></li>
                        <li class="nav-item mt-1"><a class="nav-link sidebar-link" href="#"><i class="me-3 fas fa-circle-notch fa-xs me-2"></i>Opción 2</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div style="position: absolute; bottom: 0; width: 100%; padding: 1rem; background-color: inherit;">
            <a id="darkModeToggleItem" class="nav-link sidebar-link d-flex align-items-center me-2" href="#">
                <i id="darkModeIcon" class="fas fa-moon ms-2 me-2"></i> cambiar Tema
                <div class="ms-2 form-check form-switch d-flex align-items-center m-0 d-none">
                    <input class="form-check-input" type="checkbox" id="darkModeSwitch" onclick="event.stopPropagation();">
                </div>
            </a>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="main-content" id="mainContent">
        <?= $layout->section('content') ?>
    </div>
    <style>
        .transition-transform {
            transition: transform 0.3s ease;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>

    <script>
        $(document).ready(function() {
            const $dropdownTrigger = $('#dropdownTrigger');
            const $chevronIcon = $dropdownTrigger.find('.fa-chevron-down');
            const $submenu = $('#submenu');

            // Manejar el clic en el trigger
            $dropdownTrigger.on('click', function() {
                $chevronIcon.toggleClass('rotate-180');
            });

            // Manejar el estado inicial si el menú está abierto
            if ($submenu.hasClass('show')) {
                $chevronIcon.addClass('rotate-180');
            }
        });
    </script>
    <!-- Bootstrap -->
    <script src="<?= baseUrl('./assets/vendor/bootstrap/bootstrap.bundle.min.js') ?>"></script>

    <!-- DataTables Core -->
    <script src="<?= baseUrl('./assets/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/dataTables.responsive.min.js') ?>"></script>

    <!-- DataTables Buttons y dependencias -->
    <script src="<?= baseUrl('./assets/vendor/datatables/dataTables.buttons.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/jszip.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/pdfmake.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/vfs_fonts.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/buttons.html5.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/datatables/buttons.print.min.js') ?>"></script>
    <script>
        document.documentElement.classList.remove('theme-loading');
    </script>
</body>

</html>
