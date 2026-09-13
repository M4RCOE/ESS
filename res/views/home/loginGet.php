<?php
use function Francerz\Http\Utils\baseUrl;
use function Francerz\Http\Utils\siteUrl;

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#2563eb">
    <meta name="description" content="Iniciar sesión — ESS Colima">

    <title>Iniciar sesión</title>

    <!-- Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/bootstrap/bootstrap.min.css') ?>">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/fontawesome/css/all.min.css') ?>">
    <link rel="preload" href="<?= baseUrl('./assets/vendor/fontawesome/webfonts/fa-solid-900.woff2') ?>" as="font" type="font/woff2" crossorigin>

    <!-- Inter -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">

    <!-- Estilos del login -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/login/style.css') ?>">
</head>

<body>

    <!-- ============================================
         MARCADOR DE DEBUG (quitar en producción)
         ============================================ -->
    <!-- <div style="position:fixed;top:0;left:0;background:red;color:white;padding:8px 16px;z-index:99999;font-size:12px;">
        ✅ loginGet.php cargado
    </div> -->

    <div class="login-wrapper">

        <!-- ============================================
             COLUMNA IMAGEN
             ============================================ -->
        <div class="login-image-col">
            <img src="<?= baseUrl('/assets/img/login.jpg') ?>"
                 alt=""
                 class="login-image">
            <div class="login-image-overlay"></div>
        </div>

        <!-- ============================================
             COLUMNA FORMULARIO
             ============================================ -->
        <div class="login-form-col">
            <div class="login-form-container">

                <form id="loginForm"
                      method="POST"
                      action="<?= siteUrl('/login') ?>"
                      novalidate
                      autocomplete="on">

                    <!-- Logo -->
                    <div class="login-logo-wrap">
                        <div class="login-logo">
                            <img src="<?= baseUrl('/assets/img/avatar.svg') ?>"
                                 alt="Avatar"
                                 class="login-logo-img">
                        </div>
                    </div>

                    <!-- Título -->
                    <h2 class="login-title">¡Bienvenido!</h2>

                    <!-- Error del servidor (si viene) -->
                    <?php if (!empty($error)): ?>
                        <div class="mb-4 login-error" role="alert">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <!-- Usuario -->
                    <div class="input-container">
                        <input type="text"
                               class="form-control input-field<?= !empty($usuario) ? ' has-value' : '' ?>"
                               id="username"
                               name="usuario"
                               value="<?= htmlspecialchars($usuario ?? '') ?>"
                               autocomplete="username"
                               required
                               autofocus>
                        <label for="username" class="input-label">
                            <i class="fas fa-user"></i>
                            <span>Usuario</span>
                        </label>
                    </div>

                    <!-- Contraseña -->
                    <div class="input-container">
                        <input type="password"
                               class="form-control input-field"
                               id="password"
                               name="contrasena"
                               autocomplete="current-password"
                               required>
                        <label for="password" class="input-label">
                            <i class="fas fa-eye toggle-password"
                               role="button"
                               tabindex="0"
                               aria-label="Mostrar contraseña"></i>
                            <span>Contraseña</span>
                        </label>
                    </div>

                    <!-- Recordarme + Olvidé -->
                    <!-- <div class="login-extras">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="remember"
                                   name="remember"
                                   value="1">
                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>
                        </div>
                        <a href="#" class="forgot-password">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div> -->

                    <!-- Botón -->
                    <button type="submit"
                            class="btn login-btn w-100"
                            id="loginBtn">
                        <span class="btn-text">Iniciar sesión</span>
                        <span class="btn-loader d-none">
                            <i class="fas fa-circle-notch fa-spin"></i>
                        </span>
                    </button>

                    <!-- Error inline (validación cliente) -->
                    <div id="loginError" class="login-error d-none" role="alert"></div>

                </form>

            </div>
        </div>
    </div>

    <!-- ============================================
         SCRIPTS
         ============================================ -->
    <script src="<?= baseUrl('./assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/login/script.js') ?>"></script>

</body>

</html>
