$(function () {
    const charts = {};
    const $body = $('body');
    const isDarkModeEnabled = localStorage.getItem("darkMode") === "true";

    // --- Funciones para crear gráficos ---
    function createBarChart() {
        const options = {
            series: [{
                name: "Sessions",
                data: [20, 16, 24, 28, 26, 22, 15, 5, 14, 16, 22, 29, 24, 19, 15, 10, 11, 15, 19, 23]
            }, {
                name: "Views",
                data: [20, 16, 24, 28, 26, 22, 15, 5, 14, 16, 22, 29, 24, 19, 15, 10, 11, 15, 19, 23]
            }],
            chart: {
                type: 'bar',
                height: 350,
                foreColor: '#4a5568',
                toolbar: {
                    show: false
                }
            },
            colors: ['#7C83FD', '#4FD1C5'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end'
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['16 Jan', '17 Jan', '18 Jan', '19 Jan', '20 Jan', '21 Jan', '22 Jan', '23 Jan', '24 Jan', '25 Jan', '26 Jan', '27 Jan', '28 Jan', '29 Jan', '30 Jan', '31 Jan', '1 Feb', '2 Feb', '3 Feb', '4 Feb'],
                labels: {
                    style: {
                        colors: '#4a5568'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#4a5568'
                    }
                }
            },
            legend: {
                labels: {
                    colors: '#4a5568'
                }
            },
            grid: {
                borderColor: '#e2e8f0'
            }
        };

        const chart = new ApexCharts(document.querySelector("#barChart"), options);
        chart.render();
        return chart;
    }

    function createDonutChart() {
        const options = {
            series: [44, 55, 41, 17],
            chart: {
                type: 'donut',
                height: 350,
                foreColor: '#4a5568'
            },
            labels: ['Social Media', 'Blog', 'External', 'Direct'],
            colors: ['#7C83FD', '#4FD1C5', '#F6AD55', '#FC8181'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: '#4a5568'
                        }
                    }
                }
            }],
            legend: {
                position: 'right',
                labels: {
                    colors: '#4a5568'
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#donutChart"), options);
        chart.render();
        return chart;
    }

    function createRadialBarChart() {
        const options = {
            series: [65],
            chart: {
                height: 350,
                type: 'radialBar',
                foreColor: '#4a5568'
            },
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '65%',
                    },
                    dataLabels: {
                        name: {
                            show: false
                        },
                        value: {
                            color: '#4a5568',
                            fontSize: '30px',
                            show: true,
                            formatter: function (val) {
                                return val + '%';
                            }
                        }
                    }
                }
            },
            colors: ['#7C83FD'],
            labels: ['Bounce Rate']
        };

        const chart = new ApexCharts(document.querySelector("#radialBarChart"), options);
        chart.render();
        return chart;
    }

    function createSparkline() {
        const options = {
            series: [{
                data: [25, 66, 41, 59, 25, 44, 12, 36, 9, 21]
            }],
            chart: {
                type: 'line',
                height: 100,
                sparkline: {
                    enabled: true
                },
                foreColor: '#4a5568'
            },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#7C83FD']
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                marker: {
                    show: false
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#sparklineChart"), options);
        chart.render();
        return chart;
    }

    function createAreaChart() {
        const options = {
            series: [{
                name: "Adwords Views",
                data: [15, 26, 20, 33, 27, 43, 17, 26, 19]
            }, {
                name: "Adwords Clicks",
                data: [33, 21, 42, 19, 32, 25, 36, 29, 49]
            }],
            chart: {
                height: 350,
                type: 'area',
                foreColor: '#4a5568',
                toolbar: {
                    show: false
                }
            },
            colors: ['#7C83FD', '#4FD1C5'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: ['June', 'May', 'April', 'March', 'February', 'January', 'December', 'November', 'October'],
                labels: {
                    style: {
                        colors: '#4a5568'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#4a5568'
                    }
                }
            },
            legend: {
                labels: {
                    colors: '#4a5568'
                }
            },
            grid: {
                borderColor: '#e2e8f0'
            },
            tooltip: {
                theme: 'light'
            }
        };

        const chart = new ApexCharts(document.querySelector("#areaChart"), options);
        chart.render();
        return chart;
    }

    function createSparkline2() {
        const options = {
            series: [{
                data: [25, 66, 41, 59, 25, 44, 12, 36, 9, 21]
            }],
            chart: {
                type: 'area',
                height: 'auto',
                sparkline: {
                    enabled: true,
                },
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            stroke: {
                curve: 'straight'
            },
            fill: {
                opacity: 0.3
            },
            xaxis: {
                crosshairs: {
                    width: 1
                },
                // --- AJUSTES PARA OCULTAR EL EJE X EN SPARKLINE ---
                labels: {
                    show: false // Oculta los labels del eje X
                },
                axisBorder: {
                    show: false // Oculta la línea del borde del eje X
                },
                axisTicks: {
                    show: false // Oculta las marcas del eje X
                },
                // Asegura que no haya padding interno del eje X
                padding: {
                    left: 0,
                    right: 0
                },
            },
            yaxis: {
                min: 0,
                // --- AJUSTES CLAVE: OCULTAR LABELS Y EJE Y EN SPARKLINE ---
                labels: {
                    show: false // Oculta los labels del eje Y
                },
                axisBorder: {
                    show: false // Oculta la línea del borde del eje Y
                },
                axisTicks: {
                    show: false // Oculta las marcas del eje Y
                },
                // Asegura que no haya padding interno del eje Y
                padding: {
                    top: 0,
                    bottom: 0
                }
            },
            grid: {
                show: false, // Oculta toda la cuadrícula
                padding: { // Asegura que la cuadrícula no tenga padding
                    left: 0,
                    right: 0
                }
            },
            title: {
                text: '$135,965',
                offsetX: 0,
                style: {
                    fontSize: '24px',
                }
            },
            subtitle: {
                text: 'Profits',
                offsetX: 0,
                style: {
                    fontSize: '14px',
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#sparklineChart"), options);
        chart.render();
        return chart;
    }

    // --- Inicialización de todos los gráficos ---
    charts.barChart = createBarChart();
    charts.donutChart = createDonutChart();
    charts.radialBarChart = createRadialBarChart();
    charts.sparklineChart = createSparkline2();
    charts.areaChart = createAreaChart();

    // --- Lógica del Modo Oscuro ---
    if (isDarkModeEnabled) {
        $body.addClass('dark-mode');
        updateChartsTheme(true);
    }

    /**
      * Función para actualizar el tema de todos los gráficos.
      * Genera las opciones de tema y las aplica a cada gráfico registrado.
      * @param {boolean} isDark - True si el modo oscuro está activado, false para el modo claro.
      */
    function updateChartsTheme(isDark) {
        const textColor = isDark ? '#e2e8f0' : '#4a5568';
        const gridColor = isDark ? '#4a5568' : '#e2e8f0';
        const tooltipTheme = isDark ? 'dark' : 'light'; // <-- ¡Esta es la línea clave!

        const themeOptions = {
            chart: {
                foreColor: textColor // Actualiza el color del texto principal del gráfico
            },
            xaxis: {
                labels: {
                    style: {
                        colors: textColor // Actualiza el color de las etiquetas del eje X
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: textColor // Actualiza el color de las etiquetas del eje Y
                    }
                }
            },
            legend: {
                labels: {
                    colors: textColor // Actualiza el color de las etiquetas de la leyenda
                }
            },
            grid: {
                borderColor: gridColor // Actualiza el color del borde de la cuadrícula
            },
            tooltip: {
                // Asegúrate de que el tooltip también cambie de tema
                theme: tooltipTheme // <-- Aquí aplicamos el tema del tooltip
            }
        };

        // Itera sobre el objeto 'charts' para actualizar cada instancia de gráfico.
        for (const chartKey in charts) {
            // Verifica que la propiedad sea una instancia de gráfico y no una propiedad heredada.
            if (charts.hasOwnProperty(chartKey) && charts[chartKey]) {
                charts[chartKey].updateOptions(themeOptions);
            }
        }
    }

    // --- Manejador de Eventos para el Botón de Modo Oscuro ---
    $('#darkModeToggle').on('click', function () {
        const isDark = $(this).prop('checked');
        $body.toggleClass('dark-mode', isDark);
        localStorage.setItem("darkMode", isDark);
        updateChartsTheme(isDark);
    });
});
