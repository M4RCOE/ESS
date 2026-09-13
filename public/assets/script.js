$(function () {
    // Elementos del DOM
    const $elements = {
        sidebar: $('#sidebar'),
        overlay: $('#sidebarOverlay'),
        toggle: $('#sidebarToggle'),
        body: $('body'),
        window: $(window)
    };

    // Toggle sidebar
    $elements.toggle.on('click', function () {
        $elements.sidebar.toggleClass('active');
        $elements.overlay.toggleClass('active');
        $elements.body.css('overflow',
            $elements.window.width() < 992 && $elements.sidebar.hasClass('active') ? 'hidden' : ''
        );
    });

    // Cerrar sidebar al hacer clic en overlay
    $elements.overlay.on('click', function () {
        $elements.sidebar.removeClass('active');
        $elements.overlay.removeClass('active');
        $elements.body.css('overflow', '');
    });

    // Cerrar sidebar en pantallas grandes
    $elements.window.on('resize', function () {
        if ($elements.window.width() >= 992) {
            $elements.sidebar.removeClass('active');
            $elements.overlay.removeClass('active');
            $elements.body.css('overflow', '');
        }
    });

    // Dark Mode
    const darkMode = localStorage.getItem("darkMode") === "true";
    const $darkModeSwitch = $("#darkModeSwitch");
    const $icon = $("#darkModeIcon");
    const $elementsToToggle = $("body, .navbar, .sidebar, .main-content, .dropdown-menu, .nav-link.sidebar-link");

    function applyDarkMode(isDark) {
        // Actualizar atributo en el HTML para Bootstrap 5.3+
        if (isDark) {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        } else {
            document.documentElement.removeAttribute('data-bs-theme');
        }

        // Actualizar clases CSS personalizadas
        $elementsToToggle.toggleClass("dark-mode", isDark);

        // Actualizar icono
        if (isDark) {
            $icon.removeClass("fa-moon").addClass("fa-sun text-warning");
        } else {
            $icon.removeClass("fa-sun text-warning").addClass("fa-moon");
        }

        // Actualizar switch
        $darkModeSwitch.prop("checked", isDark);

        // Redibujar tablas DataTables para aplicar cambios de tema
        $('.dataTable').each(function() {
            if ($.fn.DataTable.isDataTable(this)) {
                $(this).DataTable().draw();
            }
        });
    }

    // Aplicar modo inicial
    applyDarkMode(darkMode);

    // Eventos
    $darkModeSwitch.on("change", function () {
        const isDarkNow = $(this).is(":checked");
        localStorage.setItem("darkMode", isDarkNow);
        applyDarkMode(isDarkNow);
    });

    $("#darkModeToggleItem").on("click", function () {
        const newState = !$darkModeSwitch.prop("checked");
        $darkModeSwitch.prop("checked", newState).trigger("change");
    });
});

function initTable(idTabla) {
    var strDate = "-" + (new Date()).toISOString().split('T')[0];
    const $tabla = $(idTabla);
    const titulo = $tabla.data('titulo');
    const nomArchivo = titulo + strDate;

    $tabla.DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>><"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-outline-secondary btn-sm mx-1',
                text: '<i class="fas fa-copy"></i> Copiar',
                exportOptions: {
                    columns: ':not(:first-child):not(:last-child)'
                }
            },
            {
                extend: 'csv',
                title: titulo,
                filename: nomArchivo,
                className: 'btn btn-outline-secondary btn-sm mx-1',
                text: '<i class="fas fa-file-csv"></i> CSV',
                exportOptions: {
                    columns: ':not(:first-child):not(:last-child)'
                }
            },
            {
                extend: 'excel',
                title: titulo,
                filename: nomArchivo,
                className: 'btn btn-outline-secondary btn-sm mx-1',
                text: '<i class="fas fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: ':not(:first-child):not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                title: titulo,
                filename: nomArchivo,
                className: 'btn btn-outline-secondary btn-sm mx-1',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                exportOptions: {
                    columns: ':not(:first-child):not(:last-child)'
                },
                orientation: 'landscape',
                pageSize: 'A4',
                customize: function (doc) {
                    var totalColumns = doc.content[1].table.body[0].length;
                    doc.content[1].table.widths = Array(totalColumns).fill('*');
                    doc.pageMargins = [20, 20, 20, 20];
                    doc.styles.tableHeader.alignment = 'center';
                    doc.styles.tableBodyEven = { alignment: 'center' };
                    doc.styles.tableBodyOdd = { alignment: 'center' };
                }
            },
            {
                extend: 'print',
                className: 'btn btn-outline-secondary btn-sm mx-1',
                text: '<i class="fas fa-print"></i> Imprimir',
                exportOptions: {
                    columns: ':not(:first-child):not(:last-child)'
                }
            }
        ],
        responsive: {
            details: {
                type: 'column',
                target: 'td:first-child'
            }
        },
        columnDefs: [
            {
                className: 'control',
                orderable: false,
                targets: 0
            },
            {
                responsivePriority: 1,
                targets: -1
            }
        ],
        order: [1, 'asc'],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                previous: '<i class="fas fa-angle-left"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                last: '<i class="fas fa-angle-double-right"></i>'
            },
            buttons: {
                copyTitle: 'Copiar al portapapeles',
                copySuccess: {
                    _: '%d filas copiadas',
                    1: '1 fila copiada'
                }
            }
        },
        initComplete: function () {
            // Asegurar que los botones tengan el espaciado correcto
            $('.dt-buttons').addClass('btn-group');
            $('.dt-button').addClass('btn').removeClass('dt-button');

            // Mejorar el campo de búsqueda
            $('.dataTables_filter input').addClass('form-control form-control-sm');
            $('.dataTables_filter label').addClass('form-label');

            // Mejorar el selector de cantidad de registros
            $('.dataTables_length select').addClass('form-select form-select-sm');
            
            // Aplicar tema oscuro si está activo
            if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
                $tabla.addClass('table-dark');
            }
        },
        drawCallback: function() {
            // Actualizar tema en cada redibujado
            if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
                $tabla.addClass('table-dark');
            } else {
                $tabla.removeClass('table-dark');
            }
        }
    });
}
