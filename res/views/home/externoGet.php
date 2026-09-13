<?php
use function Francerz\Http\Utils\baseUrl;
use function Francerz\Http\Utils\siteUrl;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#2c8a7f">
    <meta name="description" content="ESS Colima — Catálogo de productos de economía social y sostenible">

    <title>ESS Colima — Catálogo público</title>

    <!-- Anti-FOUC -->
    <style>html.theme-loading { visibility: hidden; }</style>
    <script>
        document.documentElement.classList.add('theme-loading');
        (function () {
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/bootstrap/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= baseUrl('./assets/vendor/fontawesome/css/all.min.css') ?>">
    <link rel="preload" href="<?= baseUrl('./assets/vendor/fontawesome/webfonts/fa-solid-900.woff2') ?>" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">

    <!-- Tu CSS principal -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/style.css') ?>">

    <!-- CSS de la vista pública -->
    <link rel="stylesheet" href="<?= baseUrl('./assets/public/catalogo.css') ?>">
</head>

<body class="public-body">

    <!-- ============================================
         NAVBAR PÚBLICA
         ============================================ -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid px-3">
            <div class="d-flex align-items-center">
                <h1 class="fs-3 fw-bold d-flex align-items-center m-0">
                    <i class="fas fa-leaf me-2 text-success"></i>
                    ESS Colima
                </h1>
            </div>

            <div class="ms-auto d-flex align-items-center gap-2">
                <a href="#productos" class="public-nav-link d-none d-md-inline-flex">Productos</a>
                <a href="#proveedores" class="public-nav-link d-none d-md-inline-flex">Proveedores</a>
                <a href="#nosotros" class="public-nav-link d-none d-md-inline-flex">Nosotros</a>

                <a href="<?= siteUrl('/login') ?>" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt me-1"></i>
                    Iniciar sesión
                </a>
            </div>
        </div>
    </nav>

    <!-- ============================================
         HERO — Con el look de tu card principal
         ============================================ -->
    <section class="public-hero">
        <div class="container-xl">
            <div class="card public-hero-card-main">

                <div class="row align-items-center g-4">
                    <div class="col-lg-8">
                        <h1 class="public-title mb-2">
                            <i class="fas fa-leaf text-success me-3"></i>
                            Economía Social y Sostenible
                        </h1>
                        <p class="public-subtitle mb-4">
                            Sistema de Economía social y sostenible del estado de Colima.
                            Conectamos cooperativas, productores y consumidores para construir
                            una economía más justa y solidaria.
                        </p>

                        <div class="d-flex gap-2 flex-wrap">
                            <a href="#productos" class="btn btn-primary btn-lg">
                                <i class="fas fa-box-open me-2"></i>
                                Ver productos
                            </a>
                            <a href="<?= siteUrl('/login') ?>" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Acceder al sistema
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 d-none d-lg-flex justify-content-center">
                        <div class="hero-leaf-visual">
                            <i class="fas fa-leaf"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ============================================
         KPI CARDS — Igual que en tu dashboard
         ============================================ -->
    <section class="container-xl mb-5">
        <div class="row g-3">

            <div class="col-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-box"></i></div>
                    <div class="info-title">Productos</div>
                    <div class="info-value" data-counter="248">0</div>
                    <span class="info-trend up">
                        <i class="fas fa-arrow-up"></i> 15%
                    </span>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-industry"></i></div>
                    <div class="info-title">Proveedores</div>
                    <div class="info-value" data-counter="36">0</div>
                    <span class="info-trend up">
                        <i class="fas fa-arrow-up"></i> 8%
                    </span>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="info-title">Cooperativas</div>
                    <div class="info-value" data-counter="12">0</div>
                    <span class="info-trend up">
                        <i class="fas fa-arrow-up"></i> 3 nuevos
                    </span>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="info-card">
                    <div class="info-icon"><i class="fas fa-globe-americas"></i></div>
                    <div class="info-title">Municipios</div>
                    <div class="info-value" data-counter="10">0</div>
                    <span class="info-trend up">
                        <i class="fas fa-arrow-up"></i> 2 nuevos
                    </span>
                </div>
            </div>

        </div>
    </section>

    <!-- ============================================
         PRODUCTOS
         ============================================ -->
    <section id="productos" class="public-section">
        <div class="container-xl">

            <div class="d-flex align-items-end justify-content-between flex-wrap gap-3 mb-4">
                <div>
                    <h2 class="public-section-title mb-1">
                        <i class="fas fa-box-open text-success me-2"></i>
                        Nuestros productos
                    </h2>
                    <p class="text-muted mb-0">
                        Productos de calidad ofrecidos por cooperativas y productores locales
                    </p>
                </div>

                <div class="public-filters">
                    <button class="public-filter-btn active" data-filter="all">Todos</button>
                    <button class="public-filter-btn" data-filter="materia">Materia prima</button>
                    <button class="public-filter-btn" data-filter="terminado">Terminados</button>
                    <button class="public-filter-btn" data-filter="insumo">Insumos</button>
                </div>
            </div>

            <div class="public-grid">

                <!-- Producto 1 -->
                <article class="card public-product" data-category="materia">
                    <div class="public-product-image">
                        <div class="info-icon info-icon-lg">
                            <i class="fas fa-box"></i>
                        </div>
                        <span class="badge badge-accent public-product-badge">Materia prima</span>
                    </div>

                    <div class="public-product-body">
                        <h3 class="public-product-title">Cemento gris 50kg</h3>
                        <p class="public-product-desc">
                            Cemento Portland de alta resistencia para construcción.
                            Saco de 50 kilogramos.
                        </p>

                        <div class="public-product-meta">
                            <div>
                                <i class="fas fa-industry"></i>
                                <span>Distribuidora del Pacífico</span>
                            </div>
                            <div>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Manzanillo, Colima</span>
                            </div>
                        </div>

                        <div class="public-product-footer">
                            <div class="public-product-price">
                                <span class="price-label">Desde</span>
                                <span class="price-value">$285.00</span>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm"
                                    onclick="abrirDetalle(1)">
                                Ver más <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Producto 2 -->
                <article class="card public-product" data-category="materia">
                    <div class="public-product-image">
                        <div class="info-icon info-icon-lg">
                            <i class="fas fa-tools"></i>
                        </div>
                        <span class="badge badge-accent public-product-badge">Materia prima</span>
                    </div>

                    <div class="public-product-body">
                        <h3 class="public-product-title">Varilla corrugada 3/8"</h3>
                        <p class="public-product-desc">
                            Varilla de acero corrugado grado 42, ideal para refuerzo estructural.
                        </p>

                        <div class="public-product-meta">
                            <div>
                                <i class="fas fa-industry"></i>
                                <span>Grupo Industrial Manzanillo</span>
                            </div>
                            <div>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Colima, Colima</span>
                            </div>
                        </div>

                        <div class="public-product-footer">
                            <div class="public-product-price">
                                <span class="price-label">Desde</span>
                                <span class="price-value">$142.50</span>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm"
                                    onclick="abrirDetalle(2)">
                                Ver más <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Producto 3 -->
                <article class="card public-product" data-category="terminado">
                    <div class="public-product-image">
                        <div class="info-icon info-icon-lg">
                            <i class="fas fa-paint-roller"></i>
                        </div>
                        <span class="badge badge-success public-product-badge">Terminado</span>
                    </div>

                    <div class="public-product-body">
                        <h3 class="public-product-title">Pintura vinílica blanca</h3>
                        <p class="public-product-desc">
                            Pintura vinílica de alta cobertura para interiores y exteriores.
                            Cubeta de 19 litros.
                        </p>

                        <div class="public-product-meta">
                            <div>
                                <i class="fas fa-industry"></i>
                                <span>Comercial Colima</span>
                            </div>
                            <div>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Tecomán, Colima</span>
                            </div>
                        </div>

                        <div class="public-product-footer">
                            <div class="public-product-price">
                                <span class="price-label">Desde</span>
                                <span class="price-value">$1,250.00</span>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm"
                                    onclick="abrirDetalle(3)">
                                Ver más <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Producto 4 -->
                <article class="card public-product" data-category="insumo">
                    <div class="public-product-image">
                        <div class="info-icon info-icon-lg">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <span class="badge badge-warning public-product-badge">Insumo</span>
                    </div>

                    <div class="public-product-body">
                        <h3 class="public-product-title">Caja de cartón corrugado</h3>
                        <p class="public-product-desc">
                            Caja de cartón corrugado doble pared para empaque y envío.
                            40x30x30 cm.
                        </p>

                        <div class="public-product-meta">
                            <div>
                                <i class="fas fa-industry"></i>
                                <span>Distribuidora del Pacífico</span>
                            </div>
                            <div>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Manzanillo, Colima</span>
                            </div>
                        </div>

                        <div class="public-product-footer">
                            <div class="public-product-price">
                                <span class="price-label">Desde</span>
                                <span class="price-value">$28.00</span>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm"
                                    onclick="abrirDetalle(4)">
                                Ver más <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Producto 5 -->
                <article class="card public-product" data-category="terminado">
                    <div class="public-product-image">
                        <div class="info-icon info-icon-lg">
                            <i class="fas fa-chair"></i>
                        </div>
                        <span class="badge badge-success public-product-badge">Terminado</span>
                    </div>

                    <div class="public-product-body">
                        <h3 class="public-product-title">Silla de madera artesanal</h3>
                        <p class="public-product-desc">
                            Silla hecha a mano por artesanos locales con madera certificada
                            de la región.
                        </p>

                        <div class="public-product-meta">
                            <div>
                                <i class="fas fa-industry"></i>
                                <span>Cooperativa Artesanal Colima</span>
                            </div>
                            <div>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Villa de Álvarez, Colima</span>
                            </div>
                        </div>

                        <div class="public-product-footer">
                            <div class="public-product-price">
                                <span class="price-label">Desde</span>
                                <span class="price-value">$850.00</span>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm"
                                    onclick="abrirDetalle(5)">
                                Ver más <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Producto 6 -->
                <article class="card public-product" data-category="insumo">
                    <div class="public-product-image">
                        <div class="info-icon info-icon-lg">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <span class="badge badge-warning public-product-badge">Insumo</span>
                    </div>

                    <div class="public-product-body">
                        <h3 class="public-product-title">Semilla de maíz criollo</h3>
                        <p class="public-product-desc">
                            Semilla de maíz criollo de la región, libre de transgénicos.
                            Bolsa de 1 kg.
                        </p>

                        <div class="public-product-meta">
                            <div>
                                <i class="fas fa-industry"></i>
                                <span>Cooperativa Agrícola del Valle</span>
                            </div>
                            <div>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Comala, Colima</span>
                            </div>
                        </div>

                        <div class="public-product-footer">
                            <div class="public-product-price">
                                <span class="price-label">Desde</span>
                                <span class="price-value">$45.00</span>
                            </div>
                            <button class="btn btn-outline-secondary btn-sm"
                                    onclick="abrirDetalle(6)">
                                Ver más <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </article>

            </div>

            <div class="text-center mt-5">
                <a href="<?= siteUrl('/login') ?>" class="btn btn-primary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Inicia sesión para ver el catálogo completo
                </a>
            </div>

        </div>
    </section>

    <!-- ============================================
         PROVEEDORES
         ============================================ -->
    <section id="proveedores" class="public-section public-section-alt">
        <div class="container-xl">

            <div class="mb-4">
                <h2 class="public-section-title mb-1">
                    <i class="fas fa-industry text-success me-2"></i>
                    Nuestros proveedores
                </h2>
                <p class="text-muted mb-0">
                    Cooperativas, productores y empresas comprometidas con la ESS
                </p>
            </div>

            <div class="row g-3">

                <div class="col-md-6 col-lg-4">
                    <div class="card public-supplier">
                        <div class="info-icon info-icon-lg mb-3">
                            <i class="fas fa-industry"></i>
                        </div>
                        <h3 class="public-supplier-name">Distribuidora del Pacífico</h3>
                        <span class="badge badge-accent mb-3">Mayorista</span>
                        <p class="public-supplier-desc">
                            Distribuidora de materiales de construcción con cobertura regional.
                        </p>
                        <div class="public-supplier-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Manzanillo, Colima</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card public-supplier">
                        <div class="info-icon info-icon-lg mb-3">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h3 class="public-supplier-name">Cooperativa Agrícola del Valle</h3>
                        <span class="badge badge-success mb-3">Cooperativa</span>
                        <p class="public-supplier-desc">
                            Productores locales comprometidos con la agricultura sostenible.
                        </p>
                        <div class="public-supplier-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Comala, Colima</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card public-supplier">
                        <div class="info-icon info-icon-lg mb-3">
                            <i class="fas fa-city"></i>
                        </div>
                        <h3 class="public-supplier-name">Comercial Colima</h3>
                        <span class="badge badge-warning mb-3">Local</span>
                        <p class="public-supplier-desc">
                            Comercio local con más de 20 años sirviendo a la comunidad.
                        </p>
                        <div class="public-supplier-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Tecomán, Colima</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ============================================
         CTA FINAL
         ============================================ -->
    <section id="nosotros" class="public-section">
        <div class="container-xl">
            <div class="card public-cta">

                <div class="row align-items-center g-4">

                    <div class="col-lg-7">
                        <span class="badge badge-accent mb-3">
                            <i class="fas fa-lock me-1"></i>
                            Acceso para usuarios registrados
                        </span>

                        <h2 class="public-section-title mb-3">
                            <i class="fas fa-leaf text-success me-2"></i>
                            ¿Ya eres parte de ESS Colima?
                        </h2>

                        <p class="text-muted mb-4">
                            Inicia sesión para acceder al sistema completo: gestión de productos,
                            proveedores, pedidos, crédito social y reportes de impacto.
                        </p>

                        <div class="d-flex gap-2 flex-wrap">
                            <a href="<?= siteUrl('/login') ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Iniciar sesión
                            </a>
                            <a href="mailto:contacto@esscolima.mx" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-envelope me-2"></i>
                                Contactar
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="public-cta-grid">
                            <div class="public-cta-item">
                                <i class="fas fa-boxes-stacked"></i>
                                <span>Inventario</span>
                            </div>
                            <div class="public-cta-item">
                                <i class="fas fa-truck"></i>
                                <span>Pedidos</span>
                            </div>
                            <div class="public-cta-item">
                                <i class="fas fa-hand-holding-usd"></i>
                                <span>Crédito social</span>
                            </div>
                            <div class="public-cta-item">
                                <i class="fas fa-chart-line"></i>
                                <span>Reportes</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ============================================
         FOOTER PÚBLICO
         ============================================ -->
    <footer class="public-footer">
        <div class="container-xl">

            <div class="row g-4 py-5">

                <div class="col-md-4">
                    <h4 class="fs-4 fw-bold d-flex align-items-center mb-3">
                        <i class="fas fa-leaf me-2 text-success"></i>
                        ESS Colima
                    </h4>
                    <p class="text-muted small mb-0">
                        Plataforma de comercio justo y sostenible que conecta a
                        cooperativas, productores y consumidores de Colima.
                    </p>
                </div>

                <div class="col-md-4">
                    <h5 class="public-footer-title">Enlaces</h5>
                    <ul class="public-footer-links">
                        <li><a href="#productos">Productos</a></li>
                        <li><a href="#proveedores">Proveedores</a></li>
                        <li><a href="#nosotros">Nosotros</a></li>
                        <li><a href="<?= siteUrl('/login') ?>">Iniciar sesión</a></li>
                    </ul>
                </div>

                <div class="col-md-4">
                    <h5 class="public-footer-title">Contacto</h5>
                    <ul class="public-footer-links">
                        <li><i class="fas fa-map-marker-alt me-2"></i> Colima, México</li>
                        <li><i class="fas fa-envelope me-2"></i> contacto@esscolima.mx</li>
                        <li><i class="fas fa-phone me-2"></i> +52 312 123 4567</li>
                    </ul>
                </div>

            </div>

            <div class="public-footer-bottom">
                <span>&copy; <?= date('Y') ?> ESS Colima. Todos los derechos reservados.</span>
                <span>Hecho con <i class="fas fa-heart text-danger"></i> en Colima</span>
            </div>

        </div>
    </footer>

    <!-- ============================================
         SCRIPTS
         ============================================ -->
    <script src="<?= baseUrl('./assets/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= baseUrl('./assets/vendor/bootstrap/bootstrap.bundle.min.js') ?>"></script>

    <script>
        /* Contadores animados */
        document.querySelectorAll('[data-counter]').forEach(function (el) {
            const target = parseInt(el.dataset.counter, 10) || 0;
            const start = performance.now();
            const duration = 1200;
            function tick(now) {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.round(target * eased).toLocaleString('es-MX');
                if (progress < 1) requestAnimationFrame(tick);
            }
            requestAnimationFrame(tick);
        });

        /* Filtros */
        document.querySelectorAll('.public-filter-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const filter = this.dataset.filter;

                document.querySelectorAll('.public-filter-btn').forEach(function (b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                document.querySelectorAll('.public-product').forEach(function (card) {
                    const cat = card.dataset.category;
                    const show = filter === 'all' || cat === filter;
                    card.style.display = show ? 'flex' : 'none';
                });
            });
        });

        /* Detalle */
        function abrirDetalle(id) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Detalle del producto #' + id,
                    text: 'Aquí se mostraría el detalle completo del producto.',
                    icon: 'info',
                    confirmButtonText: 'Cerrar'
                });
            } else {
                alert('Detalle del producto #' + id);
            }
        }

        /* Scroll suave */
        document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
            anchor.addEventListener('click', function (e) {
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        /* Quitar theme-loading */
        document.addEventListener('DOMContentLoaded', function () {
            document.documentElement.classList.remove('theme-loading');
        });
    </script>
<style>
    /* ============================================
   VISTA PÚBLICA — Catálogo
   Estilo coherente con el dashboard
   ============================================ */

/* ============================================
   BODY
   ============================================ */
.public-body {
    background-image:
        radial-gradient(1200px 600px at 100% -10%, rgba(44, 138, 127, 0.05), transparent 55%),
        radial-gradient(1000px 500px at -10% 100%, rgba(58, 108, 174, 0.04), transparent 55%);
    background-attachment: fixed;
}

html[data-bs-theme="dark"] .public-body {
    background-image:
        radial-gradient(1200px 600px at 100% -10%, rgba(77, 182, 172, 0.06), transparent 55%),
        radial-gradient(1000px 500px at -10% 100%, rgba(91, 138, 199, 0.05), transparent 55%);
}

/* ============================================
   NAVBAR PÚBLICA
   ============================================ */
.public-nav-link {
    display: inline-flex;
    align-items: center;
    color: var(--color-text-secondary);
    text-decoration: none;
    font-weight: 500;
    font-size: var(--text-sm);
    padding: 0.45rem 0.85rem;
    border-radius: var(--radius-md);
    transition: all var(--transition-fast);
    margin-right: 0.25rem;
}

.public-nav-link:hover {
    color: var(--teal-500);
    background: var(--color-hover);
}

/* ============================================
   HERO
   ============================================ */
.public-hero {
    padding: calc(var(--navbar-height) + var(--space-6)) 0 var(--space-6);
}

.public-hero-card-main {
    padding: var(--space-8) var(--space-10);
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.public-title {
    font-size: var(--text-3xl);
    font-weight: 700;
    color: var(--color-text);
    letter-spacing: -0.02em;
    line-height: 1.15;
    display: flex;
    align-items: center;
}

.public-title i {
    color: var(--teal-500);
    font-size: 2.5rem;
}

.public-subtitle {
    font-size: var(--text-md);
    color: var(--color-text-secondary);
    line-height: var(--leading-relaxed);
    max-width: 640px;
}

/* Visual de la hoja (decorativo) */
.hero-leaf-visual {
    width: 200px;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg,
        var(--teal-50) 0%,
        var(--accent-50) 100%);
    color: var(--teal-500);
    font-size: 5rem;
    box-shadow:
        0 0 0 8px var(--color-surface),
        0 0 0 9px var(--color-border),
        0 20px 40px rgba(44, 138, 127, 0.15);
    animation: leafFloat 6s ease-in-out infinite;
}

html[data-bs-theme="dark"] .hero-leaf-visual {
    background: linear-gradient(135deg,
        rgba(77, 182, 172, 0.15) 0%,
        rgba(91, 138, 199, 0.12) 100%);
    color: var(--teal-300);
}

@keyframes leafFloat {
    0%, 100% { transform: translateY(0)     rotate(-2deg); }
    50%      { transform: translateY(-10px) rotate(2deg);  }
}

/* ============================================
   SECCIONES
   ============================================ */
.public-section {
    padding: var(--space-10) 0;
    position: relative;
}

.public-section-alt {
    background: var(--color-bg-subtle);
    border-top: 1px solid var(--color-border);
    border-bottom: 1px solid var(--color-border);
}

.public-section-title {
    font-size: var(--text-2xl);
    font-weight: 700;
    color: var(--color-text);
    letter-spacing: -0.02em;
    display: flex;
    align-items: center;
}

.public-section-title i {
    color: var(--teal-500);
}

/* ============================================
   FILTROS
   ============================================ */
.public-filters {
    display: flex;
    gap: var(--space-2);
    flex-wrap: wrap;
}

.public-filter-btn {
    padding: 0.5rem 1rem;
    background: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-full);
    font-size: var(--text-sm);
    font-weight: 500;
    color: var(--color-text-secondary);
    cursor: pointer;
    transition: all var(--transition-fast);
    font-family: inherit;
}

.public-filter-btn:hover {
    border-color: var(--teal-400);
    color: var(--teal-500);
}

.public-filter-btn.active {
    background: var(--teal-500);
    color: #ffffff;
    border-color: var(--teal-500);
    box-shadow: var(--shadow-teal);
}

/* ============================================
   GRID DE PRODUCTOS
   ============================================ */
.public-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: var(--space-4);
}

.public-product {
    display: flex;
    flex-direction: column;
    padding: 0;
    margin-bottom: 0;
    overflow: hidden;
    position: relative;
    transition: transform var(--transition-base),
                box-shadow var(--transition-base),
                border-color var(--transition-base);
}

.public-product:hover {
    transform: translateY(-4px);
    border-color: var(--teal-300);
    box-shadow: var(--shadow-md);
}

/* Imagen del producto */
.public-product-image {
    position: relative;
    padding: var(--space-8) var(--space-6);
    background: linear-gradient(135deg,
        var(--teal-50) 0%,
        var(--color-surface-sunken) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

html[data-bs-theme="dark"] .public-product-image {
    background: linear-gradient(135deg,
        rgba(77, 182, 172, 0.08) 0%,
        var(--color-surface-sunken) 100%);
}

.public-product-badge {
    position: absolute;
    top: var(--space-3);
    left: var(--space-3);
    z-index: 2;
}

/* Icono grande del producto (coherente con info-icon) */
.info-icon-lg {
    width: 72px;
    height: 72px;
    font-size: 1.75rem;
    border-radius: var(--radius-lg);
    background: var(--color-surface);
    border: 1px solid var(--teal-100);
    color: var(--teal-500);
    box-shadow: var(--shadow-sm);
    transition: transform var(--transition-base);
}

html[data-bs-theme="dark"] .info-icon-lg {
    background: var(--color-surface);
    border-color: rgba(77, 182, 172, 0.25);
    color: var(--teal-300);
}

.public-product:hover .info-icon-lg {
    transform: scale(1.08);
}

/* Body del producto */
.public-product-body {
    padding: var(--space-5);
    display: flex;
    flex-direction: column;
    gap: var(--space-3);
    flex: 1;
}

.public-product-title {
    font-size: var(--text-md);
    font-weight: 700;
    color: var(--color-text);
    margin: 0;
    letter-spacing: var(--tracking-tight);
    line-height: 1.3;
    transition: color var(--transition-fast);
}

.public-product:hover .public-product-title {
    color: var(--teal-500);
}

.public-product-desc {
    font-size: var(--text-sm);
    color: var(--color-text-secondary);
    line-height: var(--leading-normal);
    margin: 0;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Meta */
.public-product-meta {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: var(--space-3) 0;
    border-top: 1px solid var(--color-divider);
    border-bottom: 1px solid var(--color-divider);
}

.public-product-meta > div {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    font-size: var(--text-xs);
    color: var(--color-text-muted);
    font-weight: 500;
}

.public-product-meta i {
    width: 14px;
    text-align: center;
    flex-shrink: 0;
}

.public-product-meta > div:first-child i {
    color: var(--teal-500);
}

.public-product-meta > div:last-child i {
    color: var(--danger-500);
}

/* Footer */
.public-product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: var(--space-3);
    padding-top: var(--space-2);
}

.public-product-price {
    display: flex;
    flex-direction: column;
    line-height: 1.1;
}

.price-label {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: var(--color-text-muted);
    margin-bottom: 2px;
}

.price-value {
    font-size: var(--text-lg);
    font-weight: 800;
    color: var(--teal-500);
    letter-spacing: -0.02em;
    font-variant-numeric: tabular-nums;
}

html[data-bs-theme="dark"] .price-value {
    color: var(--teal-300);
}

/* ============================================
   PROVEEDORES
   ============================================ */
.public-supplier {
    display: flex;
    flex-direction: column;
    height: 100%;
    margin-bottom: 0;
    padding: var(--space-6);
    transition: transform var(--transition-base),
                box-shadow var(--transition-base),
                border-color var(--transition-base);
}

.public-supplier:hover {
    transform: translateY(-4px);
    border-color: var(--teal-300);
    box-shadow: var(--shadow-md);
}

.public-supplier .info-icon {
    margin-bottom: var(--space-4);
    width: 52px;
    height: 52px;
    font-size: 1.25rem;
    border-radius: var(--radius-lg);
    background: var(--teal-50);
    border-color: var(--teal-100);
    color: var(--teal-500);
}

html[data-bs-theme="dark"] .public-supplier .info-icon {
    background: rgba(77, 182, 172, 0.12);
    border-color: rgba(77, 182, 172, 0.25);
    color: var(--teal-300);
}

.public-supplier-name {
    font-size: var(--text-md);
    font-weight: 700;
    color: var(--color-text);
    margin: 0 0 var(--space-2);
    letter-spacing: var(--tracking-tight);
    line-height: 1.3;
}

.public-supplier-desc {
    font-size: var(--text-sm);
    color: var(--color-text-secondary);
    line-height: var(--leading-normal);
    margin: 0 0 var(--space-3);
    flex: 1;
}

.public-supplier-location {
    display: flex;
    align-items: center;
    gap: var(--space-2);
    padding-top: var(--space-3);
    border-top: 1px solid var(--color-divider);
    font-size: var(--text-sm);
    color: var(--color-text-muted);
    font-weight: 500;
}

.public-supplier-location i {
    color: var(--danger-500);
}

/* ============================================
   CTA FINAL
   ============================================ */
.public-cta {
    padding: var(--space-10) var(--space-8);
    background: var(--color-surface);
    border: 1px solid var(--color-border);
}

.public-cta-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--space-3);
}

.public-cta-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: var(--space-2);
    padding: var(--space-5) var(--space-3);
    background: var(--color-surface-sunken);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    transition: all var(--transition-base);
}

.public-cta-item:hover {
    transform: translateY(-3px);
    border-color: var(--teal-400);
    background: var(--teal-50);
}

html[data-bs-theme="dark"] .public-cta-item:hover {
    background: rgba(77, 182, 172, 0.08);
}

.public-cta-item i {
    font-size: 1.5rem;
    color: var(--teal-500);
}

html[data-bs-theme="dark"] .public-cta-item i {
    color: var(--teal-300);
}

.public-cta-item span {
    font-size: var(--text-xs);
    font-weight: 700;
    color: var(--color-text-secondary);
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* ============================================
   FOOTER
   ============================================ */
.public-footer {
    background: var(--color-surface);
    border-top: 1px solid var(--color-border);
    padding: var(--space-6) 0 var(--space-4);
    position: relative;
}

.public-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg,
        transparent 0%,
        var(--teal-400) 50%,
        transparent 100%);
    opacity: 0.6;
}

.public-footer-title {
    font-size: var(--text-xs);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: var(--tracking-wider);
    color: var(--color-text);
    margin: 0 0 var(--space-3);
}

.public-footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: var(--space-2);
}

.public-footer-links li {
    font-size: var(--text-sm);
    color: var(--color-text-muted);
    display: flex;
    align-items: center;
}

.public-footer-links a {
    color: var(--color-text-secondary);
    text-decoration: none;
    transition: color var(--transition-fast);
}

.public-footer-links a:hover {
    color: var(--teal-500);
}

.public-footer-links i {
    color: var(--color-text-muted);
    width: 16px;
    text-align: center;
}

.public-footer-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: var(--space-3);
    padding-top: var(--space-5);
    border-top: 1px solid var(--color-divider);
    font-size: var(--text-xs);
    color: var(--color-text-muted);
}

/* ============================================
   ANIMACIONES
   ============================================ */
.public-product,
.public-supplier {
    animation: publicFadeInUp 0.5s var(--ease-out) backwards;
}

.public-product:nth-child(1) { animation-delay: 0.05s; }
.public-product:nth-child(2) { animation-delay: 0.10s; }
.public-product:nth-child(3) { animation-delay: 0.15s; }
.public-product:nth-child(4) { animation-delay: 0.20s; }
.public-product:nth-child(5) { animation-delay: 0.25s; }
.public-product:nth-child(6) { animation-delay: 0.30s; }

@keyframes publicFadeInUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 992px) {
    .public-hero-card-main {
        padding: var(--space-6);
    }

    .public-title {
        font-size: var(--text-2xl);
    }

    .public-title i {
        font-size: 2rem;
    }

    .hero-leaf-visual {
        display: none;
    }
}

@media (max-width: 768px) {
    .public-section {
        padding: var(--space-8) 0;
    }

    .public-grid {
        grid-template-columns: 1fr;
    }

    .public-cta {
        padding: var(--space-6) var(--space-5);
    }

    .public-title {
        font-size: var(--text-xl);
    }

    .public-section-title {
        font-size: var(--text-lg);
    }
}

@media (max-width: 480px) {
    .public-hero-card-main {
        padding: var(--space-5) var(--space-4);
    }

    .public-hero .btn {
        width: 100%;
    }

    .public-filters {
        width: 100%;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: var(--space-2);
        scrollbar-width: none;
    }

    .public-filters::-webkit-scrollbar { display: none; }

    .public-filter-btn {
        white-space: nowrap;
        flex-shrink: 0;
    }

    .public-footer-bottom {
        flex-direction: column;
        text-align: center;
    }
}

/* ============================================
   ACCESIBILIDAD
   ============================================ */
@media (prefers-reduced-motion: reduce) {
    .hero-leaf-visual,
    .public-product,
    .public-supplier {
        animation: none;
    }
}
</style>
</body>

</html>
