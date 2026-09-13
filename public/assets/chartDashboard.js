/* ============================================
   CHARTS — Módulo de gráficos ApexCharts
   ============================================ */
;(function ($) {
    'use strict';

    /* ----------------------------------------
       PALETA FORMAL + VISTOSA
       ----------------------------------------
       · Modo claro  → tonos suaves y elegantes
       · Modo oscuro → tonos luminosos y vivos
       ---------------------------------------- */
    const THEME = {
        light: {
            text:       '#475569',
            textSoft:   '#64748b',
            grid:       '#e5e9f0',
            tooltip:    'light',
            colors:     ['#5b8ac7', '#4db6ac', '#e0a94a', '#c96f7e', '#8b8bd4'],
            colorsSoft: ['#8aafdb', '#7dd3c8', '#f3c777', '#e0a5b0', '#b4b4e5'],
            donutLabelColor:   '#ffffff',
            donutLabelBgColor: 'rgba(15, 23, 42, 0.78)'
        },
        dark: {
            text:       '#cbd5e1',
            textSoft:   '#94a3b8',
            grid:       'rgba(255, 255, 255, 0.07)',
            tooltip:    'dark',
            colors:     ['#5b8ac7', '#3ec8dd', '#e0a94a', '#e57373', '#a5a0f0'],
            colorsSoft: ['#8aafdb', '#7dd3c8', '#f3c777', '#f0a5a5', '#c8c4f5'],
            donutLabelColor:   '#0f172a',
            donutLabelBgColor: 'rgba(255, 255, 255, 0.88)'
        }
    };

    const getTheme = () =>
        document.documentElement.getAttribute('data-bs-theme') === 'dark'
            ? THEME.dark
            : THEME.light;

    /* ----------------------------------------
       REGISTRO DE GRÁFICOS
       ---------------------------------------- */
    const charts = {};

    function registerChart(id, factory) {
        const el = document.querySelector(id);
        if (!el) return null;

        try {
            const chart = factory(el);
            chart.render();
            charts[id] = chart;
            return chart;
        } catch (err) {
            console.error(`Error al crear el gráfico "${id}":`, err);
            return null;
        }
    }

    /* ----------------------------------------
       HELPERS DE ESTILO
       ---------------------------------------- */
    function axisOptions(t) {
        return {
            labels: {
                style: {
                    colors: t.text,
                    fontSize: '12px',
                    fontWeight: 500
                }
            }
        };
    }

    function legendOptions(t) {
        return {
            labels: { colors: t.text },
            markers: {
                width: 8,
                height: 8,
                radius: 2
            },
            itemMargin: {
                horizontal: 12,
                vertical: 4
            },
            fontWeight: 500
        };
    }

    function gridOptions(t) {
        return {
            borderColor: t.grid,
            strokeDashArray: 3,
            padding: { left: 8, right: 8 },
            xaxis: { lines: { show: false } },
            yaxis: { lines: { show: true } }
        };
    }

    /* ========================================
       BAR CHART — Navy + Teal
       ======================================== */
    function createBarChart(el) {
        const t = getTheme();
        return new ApexCharts(el, {
            series: [
                {
                    name: 'Sesiones',
                    data: [20,16,24,28,26,22,15,5,14,16,22,29,24,19,15,10,11,15,19,23]
                },
                {
                    name: 'Vistas',
                    data: [20,16,24,28,26,22,15,5,14,16,22,29,24,19,15,10,11,15,19,23]
                }
            ],
            chart: {
                type: 'bar',
                height: 350,
                foreColor: t.text,
                toolbar: { show: false },
                background: 'transparent',
                fontFamily: 'Inter, Segoe UI, sans-serif'
            },
            colors: [t.colors[0], t.colors[1]],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '52%',
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'last'
                }
            },
            dataLabels: { enabled: false },
            stroke: { show: false },
            fill: {
                type: 'solid',
                opacity: 0.95
            },
            xaxis: {
                categories: [
                    '16 Ene','17 Ene','18 Ene','19 Ene','20 Ene','21 Ene','22 Ene',
                    '23 Ene','24 Ene','25 Ene','26 Ene','27 Ene','28 Ene','29 Ene',
                    '30 Ene','31 Ene','1 Feb','2 Feb','3 Feb','4 Feb'
                ],
                ...axisOptions(t),
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: axisOptions(t),
            legend: legendOptions(t),
            grid: gridOptions(t),
            tooltip: {
                theme: t.tooltip,
                style: { fontSize: '12px' }
            }
        });
    }

    /* ========================================
       DONUT CHART — Con labels legibles
       ======================================== */
    function createDonutChart(el) {
        const t = getTheme();
        return new ApexCharts(el, {
            series: [44, 55, 41, 17],
            chart: {
                type: 'donut',
                height: 350,
                foreColor: t.text,
                background: 'transparent',
                fontFamily: 'Inter, Segoe UI, sans-serif'
            },
            labels: ['Redes sociales', 'Blog', 'Externo', 'Directo'],
            colors: t.colors,
            legend: {
                position: 'right',
                ...legendOptions(t)
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontWeight: 700,
                    fontFamily: 'Inter, sans-serif',
                    colors: [t.donutLabelColor]
                },
                background: {
                    enabled: true,
                    foreColor: t.donutLabelBgColor,
                    borderRadius: 4,
                    padding: 4,
                    opacity: 0.9,
                    borderWidth: 0
                },
                dropShadow: { enabled: false }
            },
            stroke: {
                show: true,
                width: 3,
                colors: ['transparent']
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '13px',
                                fontWeight: 500,
                                color: t.textSoft,
                                offsetY: -8
                            },
                            value: {
                                show: true,
                                fontSize: '22px',
                                fontWeight: 600,
                                color: t.text,
                                offsetY: 4,
                                formatter: (val) => val
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '13px',
                                fontWeight: 500,
                                color: t.textSoft,
                                formatter: (w) => {
                                    return w.globals.seriesTotals
                                        .reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: { width: 220 },
                    legend: {
                        position: 'bottom',
                        labels: { colors: t.text }
                    }
                }
            }],
            tooltip: { theme: t.tooltip }
        });
    }

    /* ========================================
       RADIAL BAR — Navy profundo
       ======================================== */
    function createRadialBarChart(el) {
        const t = getTheme();
        return new ApexCharts(el, {
            series: [65],
            chart: {
                height: 350,
                type: 'radialBar',
                foreColor: t.text,
                background: 'transparent',
                fontFamily: 'Inter, Segoe UI, sans-serif'
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    hollow: {
                        size: '65%',
                        background: 'transparent'
                    },
                    track: {
                        background: t.grid,
                        strokeWidth: '100%',
                        margin: 0,
                        opacity: 0.5
                    },
                    dataLabels: {
                        name: {
                            show: true,
                            fontSize: '14px',
                            fontWeight: 500,
                            color: t.textSoft,
                            offsetY: -10
                        },
                        value: {
                            color: t.text,
                            fontSize: '32px',
                            fontWeight: 700,
                            show: true,
                            offsetY: 6,
                            formatter: (val) => val + '%'
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    gradientToColors: [t.colors[1]],
                    stops: [0, 100]
                }
            },
            colors: [t.colors[0]],
            labels: ['Tasa de rebote'],
            stroke: { lineCap: 'round' },
            tooltip: { theme: t.tooltip }
        });
    }

    /* ========================================
       SPARKLINE — KPI con título y subtítulo
       ======================================== */
    function createSparkline(el) {
        const t = getTheme();
        return new ApexCharts(el, {
            series: [{
                name: 'Ganancias',
                data: [25, 66, 41, 59, 25, 44, 12, 36, 9, 21]
            }],
            chart: {
                type: 'area',
                height: 'auto',
                sparkline: { enabled: true },
                background: 'transparent',
                padding: { left: 0, right: 0, top: 0, bottom: 0 },
                fontFamily: 'Inter, Segoe UI, sans-serif'
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.02,
                    stops: [0, 90, 100]
                }
            },
            colors: [t.colors[0]],
            xaxis: {
                crosshairs: { width: 1 },
                labels:     { show: false },
                axisBorder: { show: false },
                axisTicks:  { show: false },
                padding:    { left: 0, right: 0 }
            },
            yaxis: {
                min: 0,
                labels:     { show: false },
                axisBorder: { show: false },
                axisTicks:  { show: false },
                padding:    { top: 0, bottom: 0 }
            },
            grid: {
                show: false,
                padding: { left: 0, right: 0 }
            },
            title: {
                text: '$135,965',
                offsetX: 0,
                style: {
                    fontSize: '26px',
                    fontWeight: 700,
                    color: t.text,
                    fontFamily: 'Inter, sans-serif'
                }
            },
            subtitle: {
                text: 'Ganancias',
                offsetX: 0,
                style: {
                    fontSize: '13px',
                    fontWeight: 500,
                    color: t.textSoft,
                    fontFamily: 'Inter, sans-serif'
                }
            },
            tooltip: { theme: t.tooltip }
        });
    }

    /* ========================================
       AREA CHART — Navy + Teal con gradiente
       ======================================== */
    function createAreaChart(el) {
        const t = getTheme();
        return new ApexCharts(el, {
            series: [
                { name: 'Vistas', data: [15,26,20,33,27,43,17,26,19] },
                { name: 'Clics',  data: [33,21,42,19,32,25,36,29,49] }
            ],
            chart: {
                height: 350,
                type: 'area',
                foreColor: t.text,
                toolbar: { show: false },
                background: 'transparent',
                fontFamily: 'Inter, Segoe UI, sans-serif'
            },
            colors: [t.colors[0], t.colors[1]],
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.02,
                    stops: [0, 90, 100]
                }
            },
            markers: {
                size: 0,
                hover: { size: 6 },
                strokeWidth: 2,
                strokeColors: '#fff'
            },
            xaxis: {
                categories: [
                    'Junio','Mayo','Abril','Marzo','Febrero',
                    'Enero','Diciembre','Noviembre','Octubre'
                ],
                ...axisOptions(t),
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: axisOptions(t),
            legend: legendOptions(t),
            grid: gridOptions(t),
            tooltip: {
                theme: t.tooltip,
                style: { fontSize: '12px' }
            }
        });
    }

    /* ----------------------------------------
       ACTUALIZAR TEMA DE TODOS LOS GRÁFICOS
       ---------------------------------------- */
    function updateChartsTheme() {
        const t = getTheme();

        const themeOptions = {
            chart:  { foreColor: t.text },
            colors: t.colors,
            xaxis:  axisOptions(t),
            yaxis:  axisOptions(t),
            legend: legendOptions(t),
            grid:   gridOptions(t),
            tooltip: { theme: t.tooltip },
            title:    { style: { color: t.text } },
            subtitle: { style: { color: t.textSoft } },
            dataLabels: {
                style: {
                    colors: [t.donutLabelColor]
                },
                background: {
                    foreColor: t.donutLabelBgColor
                }
            },
            plotOptions: {
                radialBar: {
                    track: { background: t.grid, opacity: 0.5 },
                    dataLabels: {
                        name:  { color: t.textSoft },
                        value: { color: t.text }
                    }
                },
                pie: {
                    donut: {
                        labels: {
                            name:  { color: t.textSoft },
                            value: { color: t.text },
                            total: { color: t.textSoft }
                        }
                    }
                }
            }
        };

        Object.values(charts).forEach((chart) => {
            if (chart && typeof chart.updateOptions === 'function') {
                chart.updateOptions(themeOptions, false, true);
            }
        });
    }

    /* ----------------------------------------
       INICIALIZACIÓN
       ---------------------------------------- */
    function initCharts() {
        registerChart('#barChart',       createBarChart);
        registerChart('#donutChart',     createDonutChart);
        registerChart('#radialBarChart', createRadialBarChart);
        registerChart('#sparklineChart', createSparkline);
        registerChart('#areaChart',      createAreaChart);
    }

    /* ----------------------------------------
       OBSERVADOR DE TEMA (Bootstrap 5.3)
       ---------------------------------------- */
    function observeThemeChanges() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'data-bs-theme') {
                    updateChartsTheme();
                }
            });
        });

        observer.observe(document.documentElement, {
            attributes: true,
            attributeFilter: ['data-bs-theme']
        });
    }

    /* ----------------------------------------
       ARRANQUE
       ---------------------------------------- */
    $(function () {
        requestAnimationFrame(() => {
            initCharts();
            observeThemeChanges();
        });
    });

})(jQuery);
