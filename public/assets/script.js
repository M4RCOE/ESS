/* ============================================
   APP PRINCIPAL
   ============================================ */
$(function () {
    const MOBILE_BREAKPOINT = 992;
    const STORAGE_KEY = 'darkMode';

    /* ----------------------------------------
       SIDEBAR
       ---------------------------------------- */
    const $sidebar = $('#sidebar');
    const $overlay = $('#sidebarOverlay');
    const $toggle  = $('#sidebarToggle');
    const $body    = $('body');

    const isMobile = () => $(window).width() < MOBILE_BREAKPOINT;

    function closeSidebar() {
        $sidebar.removeClass('active');
        $overlay.removeClass('active');
        $body.css('overflow', '');
    }

    if ($toggle.length) {
        $toggle.on('click', function () {
            const willOpen = !$sidebar.hasClass('active');
            $sidebar.toggleClass('active');
            $overlay.toggleClass('active');
            $body.css('overflow', willOpen && isMobile() ? 'hidden' : '');
        });
    }

    if ($overlay.length) {
        $overlay.on('click', closeSidebar);
    }

    let resizeTimer;
    $(window).on('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (!isMobile()) closeSidebar();
        }, 150);
    });

    /* ----------------------------------------
       DARK MODE
       ---------------------------------------- */
    const $darkModeSwitch = $('#darkModeSwitch');
    const $icon           = $('#darkModeIcon');

    function applyDarkMode(isDark) {
        document.documentElement.setAttribute(
            'data-bs-theme',
            isDark ? 'dark' : 'light'
        );

        if ($icon.length) {
            $icon
                .toggleClass('fa-moon', !isDark)
                .toggleClass('fa-sun text-warning', isDark);
        }

        if ($darkModeSwitch.length) {
            $darkModeSwitch.prop('checked', isDark);
        }

        $('.dataTable').each(function () {
            if ($.fn.DataTable && $.fn.DataTable.isDataTable(this)) {
                $(this).DataTable().draw(false);
            }
        });
    }

    const savedTheme  = localStorage.getItem(STORAGE_KEY);
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const initialDark = savedTheme !== null ? savedTheme === 'true' : prefersDark;

    applyDarkMode(initialDark);

    if ($darkModeSwitch.length) {
        $darkModeSwitch.on('change', function () {
            const isDark = $(this).is(':checked');
            localStorage.setItem(STORAGE_KEY, isDark);
            applyDarkMode(isDark);
        });
    }

    $('#darkModeToggleItem').on('click', function () {
        if ($darkModeSwitch.length) {
            $darkModeSwitch
                .prop('checked', !$darkModeSwitch.prop('checked'))
                .trigger('change');
        }
    });

    window.matchMedia('(prefers-color-scheme: dark)')
        .addEventListener('change', function (e) {
            if (localStorage.getItem(STORAGE_KEY) === null) {
                applyDarkMode(e.matches);
            }
        });

    /* ----------------------------------------
       SALUDO CONTEXTUAL
       ---------------------------------------- */
    const $greeting = $('#userGreeting');
    if ($greeting.length) {
        const hour = new Date().getHours();
        let greeting = 'Buenos días';
        if (hour >= 12 && hour < 19) greeting = 'Buenas tardes';
        else if (hour >= 19 || hour < 5) greeting = 'Buenas noches';
        $greeting.text(greeting);
    }

    /* ----------------------------------------
       CONTADORES ANIMADOS
       ---------------------------------------- */
    const $counters = $('[data-counter]');
    if ($counters.length && 'IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter($(entry.target));
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        $counters.each(function () {
            observer.observe(this);
        });
    } else if ($counters.length) {
        $counters.each(function () {
            animateCounter($(this));
        });
    }

    function animateCounter($el) {
        const target   = parseInt($el.data('counter'), 10) || 0;
        const duration = 1200;
        const start    = performance.now();

        function tick(now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased    = 1 - Math.pow(1 - progress, 3);
            const current  = Math.round(target * eased);
            $el.text(current.toLocaleString('es-MX'));
            if (progress < 1) requestAnimationFrame(tick);
        }
        requestAnimationFrame(tick);
    }

    /* ----------------------------------------
       TOGGLE DE CONTRASEÑA
       ---------------------------------------- */
    $(document).on('click', '[data-toggle="password"]', function () {
        const $btn   = $(this);
        const $input = $($btn.data('target'));
        if (!$input.length) return;

        const isPassword = $input.attr('type') === 'password';
        $input.attr('type', isPassword ? 'text' : 'password');
        $btn.find('i')
            .toggleClass('fa-eye', !isPassword)
            .toggleClass('fa-eye-slash', isPassword);
    });

    /* ----------------------------------------
       CERRAR DROPDOWNS AL CLICK FUERA
       ---------------------------------------- */
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.dropdown').length) {
            $('.dropdown-menu.show').removeClass('show');
        }
    });
});


/* ============================================
   DATATABLES — Inicialización reutilizable
   ============================================ */
function initTable(idTabla, options) {
    options = options || {};

    const $tabla = $(idTabla);
    if (!$tabla.length) {
        console.warn('initTable: no se encontró "' + idTabla + '"');
        return;
    }

    const titulo     = $tabla.data('titulo') || 'export';
    const strDate    = '-' + new Date().toISOString().split('T')[0];
    const nomArchivo = titulo + strDate;
    const exportCols = ':not(:first-child):not(:last-child)';

    const exportButtons = [
        {
            extend: 'copy',
            className: 'btn btn-outline-secondary btn-sm mx-1',
            text: '<i class="fas fa-copy"></i> Copiar'
        },
        {
            extend: 'csv',
            className: 'btn btn-outline-secondary btn-sm mx-1',
            text: '<i class="fas fa-file-csv"></i> CSV'
        },
        {
            extend: 'excel',
            className: 'btn btn-outline-secondary btn-sm mx-1',
            text: '<i class="fas fa-file-excel"></i> Excel'
        },
        {
            extend: 'pdf',
            className: 'btn btn-outline-secondary btn-sm mx-1',
            text: '<i class="fas fa-file-pdf"></i> PDF',
            orientation: 'landscape',
            pageSize: 'A4',
            customize: function (doc) {
                const totalColumns = doc.content[1].table.body[0].length;
                doc.content[1].table.widths = Array(totalColumns).fill('*');
                doc.pageMargins = [20, 20, 20, 20];
                doc.styles.tableHeader.alignment = 'center';
                doc.styles.tableBodyEven = { alignment: 'center' };
                doc.styles.tableBodyOdd  = { alignment: 'center' };
            }
        },
        {
            extend: 'print',
            className: 'btn btn-outline-secondary btn-sm mx-1',
            text: '<i class="fas fa-print"></i> Imprimir'
        }
    ].map(function (btn) {
        return {
            title:         btn.title         != null ? btn.title         : titulo,
            filename:      btn.filename      != null ? btn.filename      : nomArchivo,
            exportOptions: btn.exportOptions != null ? btn.exportOptions : { columns: exportCols },
            extend:        btn.extend,
            className:     btn.className,
            text:          btn.text,
            orientation:   btn.orientation,
            pageSize:      btn.pageSize,
            customize:     btn.customize
        };
    });

    const config = {
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: exportButtons,
        responsive: {
            details: {
                type: 'column',
                target: 'td:first-child'
            }
        },
        columnDefs: [
            { className: 'control', orderable: false, targets: 0 },
            { responsivePriority: 1, targets: -1 }
        ],
        order: [[1, 'asc']],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-MX.json',
            paginate: {
                first:    '<i class="fas fa-angle-double-left"></i>',
                previous: '<i class="fas fa-angle-left"></i>',
                next:     '<i class="fas fa-angle-right"></i>',
                last:     '<i class="fas fa-angle-double-right"></i>'
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
            $('.dt-buttons').addClass('btn-group');
            $('.dt-button').addClass('btn').removeClass('dt-button');

            $('.dataTables_filter input').addClass('form-control form-control-sm');
            $('.dataTables_filter label').addClass('form-label');
            $('.dataTables_length select').addClass('form-select form-select-sm');
        },
        drawCallback: function () {
            $tabla.css('width', '100%');
        }
    };

    return $tabla.DataTable($.extend(true, {}, config, options));
}


/* ============================================
   UI HELPERS — Toasts, Alerts, Confirms, Prompts
   ============================================ */
window.UI = (function () {
    'use strict';

    /* ----------------------------------------
       INYECCIÓN DE ESTILOS PREMIUM
       ---------------------------------------- */
    function injectPremiumStyles() {
        const styleId = 'premium-swal-styles';
        if (document.getElementById(styleId)) return;

        const style = document.createElement('style');
        style.id = styleId;
        style.textContent = `
            .swal-premium {
                border-radius: 16px !important;
                box-shadow: 0 20px 60px rgba(15, 23, 42, 0.18),
                            0 4px 12px rgba(15, 23, 42, 0.06) !important;
                font-family: 'Inter', 'Segoe UI', sans-serif !important;
                overflow: hidden;
                border: 1px solid rgba(15, 23, 42, 0.06);
                animation: swalSlideIn 320ms cubic-bezier(0.34, 1.56, 0.64, 1);
            }
            html[data-bs-theme="dark"] .swal-premium {
                border-color: rgba(255, 255, 255, 0.08);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6),
                            0 4px 12px rgba(0, 0, 0, 0.3) !important;
            }
            .swal-premium::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 4px;
                height: 100%;
            }
            .swal-info::before     { background: #3a6cae; }
            .swal-success::before  { background: #2f855a; }
            .swal-warning::before  { background: #b7791f; }
            .swal-error::before    { background: #b83232; }
            .swal-question::before { background: #6a1b9a; }
            .swal-premium-icon {
                margin-top: 0.5rem !important;
                margin-bottom: 1rem !important;
            }
            .swal-premium-title {
                font-size: 1.35rem !important;
                font-weight: 700 !important;
                letter-spacing: -0.01em !important;
                color: inherit !important;
            }
            .swal-premium-text {
                font-size: 0.95rem !important;
                line-height: 1.6 !important;
                color: #475569 !important;
            }
            html[data-bs-theme="dark"] .swal-premium-text {
                color: #a8b0bd !important;
            }
            .swal-premium-btn {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.6rem 1.15rem !important;
                border-radius: 10px !important;
                font-size: 0.875rem !important;
                font-weight: 600 !important;
                cursor: pointer !important;
                border: 1px solid transparent !important;
                transition: all 180ms ease !important;
                outline: none !important;
                min-width: 110px !important;
                margin: 0 0.35rem !important;
            }
            .swal-premium-btn-confirm {
                color: #ffffff !important;
                box-shadow: 0 1px 2px rgba(58, 108, 174, 0.25) !important;
            }
            .swal-premium-btn-confirm:hover {
                transform: translateY(-1px);
                filter: brightness(1.06);
            }
            .swal-premium-btn-cancel {
                background: transparent !important;
                color: #475569 !important;
                border: 1px solid #cbd5e1 !important;
            }
            html[data-bs-theme="dark"] .swal-premium-btn-cancel {
                color: #cbd5e1 !important;
                border-color: rgba(255, 255, 255, 0.15) !important;
            }
            .swal-premium-btn-cancel:hover {
                background: rgba(15, 23, 42, 0.05) !important;
            }
            .swal-premium-close {
                color: #94a3b8 !important;
                font-size: 1.5rem !important;
                transition: all 200ms !important;
            }
            .swal-premium-close:hover {
                color: #0f172a !important;
                transform: rotate(90deg);
            }
            .swal-premium-input {
                border-radius: 10px !important;
                border: 1px solid #cbd5e1 !important;
                padding: 0.6rem 0.9rem !important;
                font-family: inherit !important;
                font-size: 0.9rem !important;
                outline: none !important;
            }
            .swal-premium-input:focus {
                border-color: #3a6cae !important;
                box-shadow: 0 0 0 3px rgba(58, 108, 174, 0.18) !important;
            }
            @keyframes swalSlideIn {
                0%   { opacity: 0; transform: translateY(-16px) scale(0.96); }
                100% { opacity: 1; transform: translateY(0)     scale(1);    }
            }
        `;
        document.head.appendChild(style);
    }

    /* ----------------------------------------
       PALETA
       ---------------------------------------- */
    const PALETTE = {
        info:     { icon: '#3a6cae', accent: '#3a6cae' },
        success:  { icon: '#2f855a', accent: '#2f855a' },
        warning:  { icon: '#b7791f', accent: '#b7791f' },
        error:    { icon: '#b83232', accent: '#b83232' },
        question: { icon: '#6a1b9a', accent: '#6a1b9a' }
    };
    const VALID_TYPES = ['info', 'success', 'warning', 'error', 'question'];
    const isDark = () => document.documentElement.getAttribute('data-bs-theme') === 'dark';

    /* ----------------------------------------
       SHOW TOAST (iziToast)
       ---------------------------------------- */
    function showToast(opts) {
        opts = opts || {};
        const type = VALID_TYPES.includes(opts.type) ? opts.type : 'info';

        if (typeof iziToast === 'undefined') {
            console.warn('iziToast no está disponible');
            return;
        }

        const colors = {
            info:     { bg: '#e3f2fd', border: '#2196f3', icon: '#1976d2', progress: '#2196f3', text: '#0d47a1' },
            success:  { bg: '#e8f5e9', border: '#4caf50', icon: '#2e7d32', progress: '#4caf50', text: '#1b5e20' },
            warning:  { bg: '#fff3e0', border: '#ff9800', icon: '#e65100', progress: '#ff9800', text: '#bf360c' },
            error:    { bg: '#ffebee', border: '#f44336', icon: '#c62828', progress: '#f44336', text: '#b71c1c' },
            question: { bg: '#f3e5f5', border: '#9c27b0', icon: '#6a1b9a', progress: '#9c27b0', text: '#4a148c' }
        };
        const c = colors[type];

        const defaultIcons = {
            info: 'fas fa-info-circle',
            success: 'fas fa-check-circle',
            warning: 'fas fa-exclamation-triangle',
            error: 'fas fa-times-circle',
            question: 'fas fa-question-circle'
        };

        return iziToast[type]({
            title: opts.title || '',
            message: opts.message || '',
            timeout: Math.max(opts.time || 5000, 3000),
            position: opts.position || 'topRight',
            transitionIn: opts.animateIn || 'fadeInDown',
            transitionOut: opts.animateOut || 'fadeOutUp',
            closeOnClick: opts.closeOnClick !== false,
            progressBar: opts.progressBar !== false,
            progressBarColor: opts.progressBarColor || c.progress,
            backgroundColor: opts.backgroundColor || c.bg,
            titleColor: c.text,
            messageColor: c.text,
            icon: '<i class="' + defaultIcons[type] + '" style="font-size:32px;color:' + c.icon + ';"></i>',
            iconColor: c.icon,
            pauseOnHover: opts.pauseOnHover !== false,
            class: 'toast-premium toast-' + type,
            style: {
                borderRadius: '12px',
                boxShadow: '0 10px 40px rgba(0,0,0,0.15), 0 4px 12px rgba(0,0,0,0.05)',
                borderLeft: '5px solid ' + c.border,
                fontFamily: "'Inter', 'Segoe UI', sans-serif",
                padding: '18px 24px'
            }
        });
    }

    /* ----------------------------------------
       SHOW ALERT
       ---------------------------------------- */
    function showAlert(opts) {
        opts = opts || {};
        const type = VALID_TYPES.includes(opts.type) ? opts.type : 'info';

        if (typeof Swal === 'undefined') {
            console.warn('SweetAlert2 no está disponible');
            alert((opts.title || '') + '\n' + (opts.message || ''));
            return Promise.resolve({ isConfirmed: true });
        }

        const colors = PALETTE[type];
        const dark = isDark();
        injectPremiumStyles();

        return Swal.fire({
            icon: type,
            iconColor: opts.iconColor || colors.icon,
            title: opts.title || undefined,
            text: opts.message || undefined,
            html: opts.html || undefined,
            position: opts.position || 'center',
            width: opts.width || '480px',
            padding: '1.75rem',
            background: opts.background || (dark ? '#181d27' : '#ffffff'),
            color: dark ? '#e9ecf1' : '#0f172a',
            confirmButtonText: opts.confirmText || 'Entendido',
            showConfirmButton: opts.showConfirmButton !== false,
            showCloseButton: opts.showCloseButton !== false,
            allowOutsideClick: opts.allowOutsideClick !== false,
            allowEscapeKey: opts.allowEscapeKey !== false,
            timer: opts.timer || undefined,
            timerProgressBar: !!opts.timer,
            backdrop: dark ? 'rgba(0,0,0,0.6)' : 'rgba(15,23,42,0.45)',
            customClass: {
                popup: 'swal-premium swal-' + type,
                title: 'swal-premium-title',
                htmlContainer: 'swal-premium-text',
                confirmButton: 'swal-premium-btn swal-premium-btn-confirm',
                closeButton: 'swal-premium-close',
                icon: 'swal-premium-icon'
            },
            buttonsStyling: false,
            didOpen: function (popup) {
                const btn = popup.querySelector('.swal-premium-btn-confirm');
                if (btn) btn.style.background = opts.confirmColor || colors.accent;
                if (typeof opts.onOpen === 'function') opts.onOpen(popup);
            },
            willClose: function () {
                if (typeof opts.onClose === 'function') opts.onClose();
            }
        });
    }

    /* ----------------------------------------
       SHOW CONFIRM
       ---------------------------------------- */
    function showConfirm(opts) {
        opts = opts || {};
        const type = VALID_TYPES.includes(opts.type) ? opts.type : 'question';

        if (typeof Swal === 'undefined') {
            return Promise.resolve(confirm((opts.title || '') + '\n' + (opts.message || '')));
        }

        const colors = PALETTE[type];
        const dark = isDark();
        injectPremiumStyles();

        return Swal.fire({
            icon: type,
            iconColor: opts.iconColor || colors.icon,
            title: opts.title || '¿Estás seguro?',
            text: opts.message || undefined,
            html: opts.html || undefined,
            position: opts.position || 'center',
            width: opts.width || '460px',
            padding: '1.75rem',
            background: opts.background || (dark ? '#181d27' : '#ffffff'),
            color: dark ? '#e9ecf1' : '#0f172a',
            showCancelButton: true,
            showConfirmButton: true,
            showCloseButton: opts.showCloseButton !== false,
            confirmButtonText: opts.confirmText || 'Sí, continuar',
            cancelButtonText: opts.cancelText || 'Cancelar',
            reverseButtons: opts.reverseButtons !== false,
            focusCancel: opts.focusCancel !== false,
            allowOutsideClick: opts.allowOutsideClick === true,
            allowEscapeKey: opts.allowEscapeKey !== false,
            backdrop: dark ? 'rgba(0,0,0,0.65)' : 'rgba(15,23,42,0.5)',
            customClass: {
                popup: 'swal-premium swal-confirm swal-' + type,
                title: 'swal-premium-title',
                htmlContainer: 'swal-premium-text',
                confirmButton: 'swal-premium-btn swal-premium-btn-confirm',
                cancelButton: 'swal-premium-btn swal-premium-btn-cancel',
                closeButton: 'swal-premium-close',
                icon: 'swal-premium-icon'
            },
            buttonsStyling: false,
            didOpen: function (popup) {
                const btn = popup.querySelector('.swal-premium-btn-confirm');
                if (btn) btn.style.background = opts.confirmColor || colors.accent;
                if (typeof opts.onOpen === 'function') opts.onOpen(popup);
            },
            willClose: function () {
                if (typeof opts.onClose === 'function') opts.onClose();
            }
        }).then(function (r) {
            const confirmed = r.isConfirmed === true;
            if (confirmed && typeof opts.onConfirm === 'function') opts.onConfirm(r);
            if (!confirmed && typeof opts.onCancel === 'function') opts.onCancel(r);
            return confirmed;
        });
    }

    /* ----------------------------------------
       SHOW PROMPT
       ---------------------------------------- */
    function showPrompt(opts) {
        opts = opts || {};
        const type = VALID_TYPES.includes(opts.type) ? opts.type : 'question';

        if (typeof Swal === 'undefined') {
            const v = prompt(opts.title || '', opts.inputValue || '');
            return Promise.resolve(v);
        }

        const colors = PALETTE[type];
        const dark = isDark();
        injectPremiumStyles();

        return Swal.fire({
            icon: type,
            iconColor: colors.icon,
            title: opts.title || undefined,
            text: opts.message || undefined,
            input: opts.inputType || 'text',
            inputLabel: opts.inputLabel || undefined,
            inputPlaceholder: opts.inputPlaceholder || undefined,
            inputValue: opts.inputValue || '',
            inputOptions: opts.inputOptions || undefined,
            inputValidator: opts.inputValidator || undefined,
            position: 'center',
            width: opts.width || '480px',
            padding: '1.75rem',
            background: dark ? '#181d27' : '#ffffff',
            color: dark ? '#e9ecf1' : '#0f172a',
            showCancelButton: true,
            showConfirmButton: true,
            confirmButtonText: opts.confirmText || 'Aceptar',
            cancelButtonText: opts.cancelText || 'Cancelar',
            reverseButtons: opts.reverseButtons !== false,
            focusCancel: opts.focusCancel === true,
            backdrop: dark ? 'rgba(0,0,0,0.65)' : 'rgba(15,23,42,0.5)',
            customClass: {
                popup: 'swal-premium swal-prompt swal-' + type,
                title: 'swal-premium-title',
                htmlContainer: 'swal-premium-text',
                input: 'swal-premium-input',
                confirmButton: 'swal-premium-btn swal-premium-btn-confirm',
                cancelButton: 'swal-premium-btn swal-premium-btn-cancel',
                closeButton: 'swal-premium-close',
                icon: 'swal-premium-icon'
            },
            buttonsStyling: false,
            didOpen: function (popup) {
                const btn = popup.querySelector('.swal-premium-btn-confirm');
                if (btn) btn.style.background = opts.confirmColor || colors.accent;
            }
        }).then(function (r) {
            if (r.isConfirmed && r.value !== undefined && r.value !== '') {
                return r.value;
            }
            return null;
        });
    }

    /* ----------------------------------------
       HELPERS / ATAJOS
       ---------------------------------------- */
    function formatCurrency(amount) {
        return parseFloat(amount).toFixed(2);
    }

    function alertSuccess(title, message) {
        return showAlert({ type: 'success', title: title, message: message });
    }
    function alertError(title, message) {
        return showAlert({ type: 'error', title: title, message: message });
    }
    function alertWarning(title, message) {
        return showAlert({ type: 'warning', title: title, message: message });
    }
    function alertInfo(title, message) {
        return showAlert({ type: 'info', title: title, message: message });
    }

    function confirmDelete(item) {
        item = item || 'este registro';
        return showConfirm({
            type: 'warning',
            title: '¿Eliminar?',
            message: 'Se eliminará ' + item + '. Esta acción no se puede deshacer.',
            confirmText: 'Eliminar',
            confirmColor: '#b83232',
            focusCancel: true
        });
    }

    /* ----------------------------------------
       API PÚBLICA
       ---------------------------------------- */
    return {
        showToast: showToast,
        showAlert: showAlert,
        showConfirm: showConfirm,
        showPrompt: showPrompt,
        formatCurrency: formatCurrency,
        alertSuccess: alertSuccess,
        alertError: alertError,
        alertWarning: alertWarning,
        alertInfo: alertInfo,
        confirmDelete: confirmDelete
    };
})();

console.log('✅ UI object creado:', typeof window.UI);
