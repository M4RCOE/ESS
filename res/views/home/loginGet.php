<?php

use function Francerz\Http\Utils\baseUrl;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= baseUrl("./assets/vendor/bootstrap/bootstrap.min.css") ?>">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?= baseUrl("./assets/vendor/fontawesome/css/all.min.css") ?>">
    <link rel="preload" href="<?= baseUrl("./assets/vendor/fontawesome/webfonts/fa-solid-900.woff2") ?>" as="font" type="font/woff2" crossorigin>
    <!-- jQuery -->
    <script src="<?= baseUrl("./assets/vendor/jquery/jquery.min.js") ?>"></script>
    <link rel="stylesheet" href="<?= baseUrl("./assets/login/style.css") ?>">

</head>

<body class="d-flex">
    <!-- Columna de imagen con animación -->
    <div class="d-none d-md-flex col-md-8 p-0 vh-100 overflow-hidden align-items-center">
        <img src="<?= baseUrl('/assets/Img/login.jpg') ?>" alt="Login image"
            class="login-image object-cover w-100 h-100">
    </div>

    <!-- Columna de formulario con animación -->
    <div class="col-12 col-md-4 d-flex align-items-center justify-content-center py-4">
        <div class="login-form-container rounded-4 col-10 col-sm-8">
            <form id="loginForm">
                <!-- Logo con animación -->
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <div class="login-logo rounded-circle p-1 bg-white shadow" style="width: 150px; height: 150px;">
                        <div class="rounded-circle overflow-hidden position-relative" style="width: 100%; height: 100%; background-color: #f5a623;">
                            <img src="<?= baseUrl('/assets/Img/avatar.svg') ?>" alt="Avatar"
                                class="position-absolute top-50 start-50 translate-middle"
                                style="width: 100px;">
                        </div>
                    </div>
                </div>

                <!-- Título -->
                <h2 class="text-center mb-4 text-primary fw-bold mb-5 animate__animated animate__fadeIn">Welcome!!</h2>

                <!-- Campo Usuario - Estructura original que funcionaba -->
                <div class="input-container position-relative">
                    <input type="text" class="form-control input-field mb-3" id="username" required autofocus>
                    <label class="ps-0 input-label">
                        <i class="fas fa-user me-2"></i>User
                    </label>
                </div>

                <!-- Campo Contraseña - Estructura original que funcionaba -->
                <div class="input-container position-relative">
                    <input type="password" class="form-control input-field mb-3" id="password" autocomplete="new-password" required>
                    <label class="ps-0 input-label">
                        <i class="fas fa-eye me-2 toggle-password" style="cursor: pointer;"></i>
                        Password
                    </label>
                </div>

                <!-- Enlace olvidar contraseña -->
                <div class="text-end mb-4">
                    <a href="#" class="forgot-password text-decoration-none text-primary small fw-medium">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>

                <!-- Botón de login -->
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold login-btn animate__animated animate__pulse animate__delay-1s">
                    LOGIN
                </button>
            </form>
        </div>
    </div>

    <script src="<?= baseUrl("./assets/vendor/bootstrap/bootstrap.bundle.min.js") ?>"></script>
    <script src="<?= baseUrl("./assets/login/script.js") ?>"></script>

</body>

</html>
