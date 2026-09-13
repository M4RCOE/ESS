<?= $layout = $view->loadLayout('@layouts/default') ?>
<?= $layout->startSection('content') ?>

<div class="container-xl">
    <div class="card shadow-sm mb-3">
        <div class="card-body p-4">
            <h1 class="page-title mb-1">
                <i class="fas fa-leaf text-success me-2"></i>
                Economía Social y Sostenible
            </h1>
            <p class="text-muted mb-0">
                Sistema de Economía social y sostenible del estado de Colima.
            </p>
        </div>
    </div>
</div>

<!-- KPIs ESS -->
<div class="container-xl">
    <div class="row g-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="info-card">
                <div class="info-icon" style="background:#eefaf8;border-color:#d4f1ed;color:#2c8a7f;">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="info-title">Usuarios</div>
                <div class="info-value" data-counter="47">0</div>
                <span class="info-trend up"><i class="fas fa-arrow-up"></i> 15%</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-card">
                <div class="info-icon" style="background:#eefaf8;border-color:#d4f1ed;color:#2c8a7f;">
                    <i class="fas fa-recycle"></i>
                </div>
                <div class="info-title">Productos</div>
                <div class="info-value" data-counter="12840">0</div>
                <span class="info-trend up"><i class="fas fa-arrow-up"></i> 22%</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-card">
                <div class="info-icon" style="background:#eefaf8;border-color:#d4f1ed;color:#2c8a7f;">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div class="info-title">Pedidos</div>
                <div class="info-value" data-counter="3200">0</div>
                <span class="info-trend up"><i class="fas fa-arrow-up"></i> 8%</span>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="info-card">
                <div class="info-icon" style="background:#eefaf8;border-color:#d4f1ed;color:#2c8a7f;">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <div class="info-title">Proveedores</div>
                <div class="info-value" data-counter="9">0</div>
                <span class="info-trend up"><i class="fas fa-arrow-up"></i> 3 nuevos</span>
            </div>
        </div>
    </div>
</div>

<!-- Gráfico de impacto -->
<div class="container-xl">
    <div class="card shadow-sm mb-3">
        <div class="card-body p-4">
            <h3 class="h5 mb-3">
                <i class="fas fa-chart-line text-success me-2"></i>
                Pedidos anuales
            </h3>
            <div id="areaChart"></div>
        </div>
    </div>
</div>

<?= $layout->endSection() ?>
