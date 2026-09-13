<?= $layout = $view->loadLayout('@layouts/default') ?>
<?= $layout->startSection('content') ?>

<!-- Card de Bienvenida -->
<div class="card container-xl shadow-sm d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="border-0 rounded-3 overflow-hidden" style="width: 100%; max-width: 600px;">
        <div class="card-body p-4 text-center">
            <div class="bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px;">
                <i class="fas fa-check-circle text-success" style="font-size: 2rem;"></i>
            </div>

            <h3 class="fw-semibold mb-2">¡Bienvenido!</h3>
            <p class="text-muted mb-3">La prueba de carga se ha completado exitosamente</p>
            <hr class="mx-auto my-3" style="width: 80px; opacity: 0.15;">

            <!-- Badges de tecnologías -->
            <div class="d-flex flex-wrap justify-content-center gap-2">
                <span class="badge rounded-pill bg-light text-dark border border-1 border-light-subtle px-2 py-1">
                    <i class="fab fa-bootstrap text-primary me-1"></i> Bootstrap
                </span>
                <span class="badge rounded-pill bg-light text-dark border border-1 border-light-subtle px-2 py-1">
                    <i class="fab fa-font-awesome text-primary me-1"></i> Font Awesome
                </span>
                <span class="badge rounded-pill bg-light text-dark border border-1 border-light-subtle px-2 py-1">
                    <i class="fas fa-chart-bar text-primary me-1"></i> Apexcharts
                </span>
                <span class="badge rounded-pill bg-light text-dark border border-1 border-light-subtle px-2 py-1">
                    <i class="fab fa-js-square text-primary me-1"></i> jQuery
                </span>
                <span class="badge rounded-pill bg-light text-dark border border-1 border-light-subtle px-2 py-1">
                    <i class="fas fa-table text-primary me-1"></i> DataTables
                </span>
                <span class="badge rounded-pill bg-light text-dark border border-1 border-light-subtle px-2 py-1">
                    <i class="fab fa-php text-primary me-1"></i> PHP Dotenv
                </span>
                <span class="badge rounded-pill bg-light text-dark border border-1 border-light-subtle px-2 py-1">
                    <i class="fas fa-server text-primary me-1"></i> Slim Framework
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Usuarios -->
<div class="card container-xl shadow-sm">
<table id="miTabla" class="table table-hover table-bordered align-middle mb-0">
    <thead class="table-primary text-center">
        <tr>
            <th scope="col"></th>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col" class="d-none d-md-table-cell">Email</th>
            <th scope="col" class="d-none d-md-table-cell">Teléfono</th>
            <th scope="col" class="d-none d-md-table-cell">Acciones</th>
        </tr>
    </thead>
    <tbody class="text-center">
        <tr>
            <td></td>
            <td>1</td>
            <td>Ana López</td>
            <td class="d-none d-md-table-cell">ana@example.com</td>
            <td class="d-none d-md-table-cell">555-1234</td>
            <td class="d-none d-md-table-cell">
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-sm btn-outline-primary rounded-circle" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger rounded-circle" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>
    </tbody>
</table>
</div>



<!-- Gráficos con ApexCharts -->
<div class="dashboard">
    <div class="card">
        <div id="barChart" class="chart-container"></div>
    </div>

    <div class="d-flex flex-wrap">
        <div class="card col-12 col-lg-4">
            <div id="donutChart" class="chart-container"></div>
        </div>
        <div class="card col-12 col-lg-4">
            <div id="radialBarChart" class="chart-container"></div>
        </div>
        <div class="card col-12 col-lg-4">
            <div class="sparkline-container">
                <div id="sparklineChart" class="chart-container"></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div id="areaChart" class="chart-container"></div>
    </div>
</div>

<!-- Inicialización de DataTables -->
<script>
    $(function() {
        initTable('#miTabla');
    });
</script>

<?= $layout->endSection() ?>
