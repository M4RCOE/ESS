class ApexChartCreator {
    constructor() {
        this.chartOptions = {
            chart: {
                type: 'line',
                height: 350,
                foreColor: '#373d3f' // Color de texto por defecto (modo claro)
            },
            series: [],
            xaxis: {
                categories: []
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#373d3f'] // Color texto data labels
                }
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: '',
                align: 'center',
                style: {
                    color: '#373d3f' // Color título
                }
            },
            colors: ['#7C83FD'],
            grid: {
                borderColor: '#e5e7eb' // Color grid modo claro
            },
            legend: {
                labels: {
                    colors: '#373d3f' // Color leyenda
                }
            }
        };
        
        // Almacenar todas las instancias de gráficos
        this.chartInstances = {};
        
        // Configuración de temas
        this.themeConfig = {
            light: {
                chart: {
                    foreColor: '#333333', // Color oscuro para el texto
                    background: 'transparent'
                },
                grid: {
                    borderColor: '#f0f0f0' // Gris muy claro
                },
                dataLabels: {
                    style: {
                        colors: ['#b0b0b0'] // Gris suave
                    }
                },
                title: {
                    style: {
                        color: '#333333' // Título con el mismo color que el texto
                    }
                },
                legend: {
                    labels: {
                        colors: '#333333' // Color para etiquetas de la leyenda
                    }
                },
                xaxis: {
                    labels: {
                        style: {
                            colors: '#333333' // Color para las etiquetas del eje X
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#333333' // Color para las etiquetas del eje Y
                        }
                    }
                }
            },
            dark: {
                chart: {
                    foreColor: '#e0e0e0', // Gris muy claro para el texto
                    background: 'transparent'
                },
                grid: {
                    borderColor: '#444444' // Gris oscuro para la cuadrícula
                },
                dataLabels: {
                    style: {
                        colors: ['#e0e0e0'] // Gris claro para los datos
                    }
                },
                title: {
                    style: {
                        color: '#e0e0e0' // Título en gris claro
                    }
                },
                legend: {
                    labels: {
                        colors: '#e0e0e0' // Leyenda en gris claro
                    }
                },
                xaxis: {
                    labels: {
                        style: {
                            colors: '#e0e0e0' // Etiquetas del eje X en gris claro
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#e0e0e0' // Etiquetas del eje Y en gris claro
                        }
                    }
                }
            }
        };        
    }

    // Método para actualizar todos los gráficos al cambiar el tema
    updateChartsTheme(isDark) {
        const theme = isDark ? 'dark' : 'light';
        Object.values(this.chartInstances).forEach(chart => {
            chart.updateOptions(this.themeConfig[theme]);
        });
    }

    createSparkline(containerId, data, color = '#7C83FD', title = '') {
        const options = {
            chart: {
                type: 'line',
                height: 140,
                sparkline: { enabled: true },
                group: 'sparklines',
                foreColor: this.chartOptions.chart.foreColor
            },
            series: [{
                name: title,
                data: data
            }],
            stroke: {
                curve: 'smooth'
            },
            markers: {
                size: 0
            },
            tooltip: {
                fixed: { enabled: true, position: 'right' },
                x: { show: false }
            },
            title: {
                text: title,
                style: { 
                    fontSize: '26px',
                    color: this.chartOptions.chart.foreColor
                }
            },
            colors: [color]
        };

        return this.createChart(containerId, options);
    }

    createBarChart(containerId, data, categories, color = '#7C83FD') {
        const options = {
            ...this.chartOptions,
            chart: {
                ...this.chartOptions.chart,
                type: 'bar'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '10%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end'
                }
            },
            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Datos',
                data: data
            }],
            xaxis: {
                categories: categories,
                labels: {
                    style: {
                        colors: this.chartOptions.chart.foreColor
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: this.chartOptions.chart.foreColor
                    }
                }
            },
            colors: Array.isArray(color) ? color : [color],
            legend: {
                labels: {
                    colors: this.chartOptions.chart.foreColor
                }
            }
        };

        return this.createChart(containerId, options);
    }

    createLineChart(containerId, data, categories, color = '#7C83FD') {
        const options = {
            ...this.chartOptions,
            chart: {
                ...this.chartOptions.chart,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            series: [{
                name: "Valores",
                data: data
            }],
            xaxis: {
                categories: categories,
                labels: {
                    style: {
                        colors: this.chartOptions.chart.foreColor
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: this.chartOptions.chart.foreColor
                    }
                }
            },
            colors: Array.isArray(color) ? color : [color],
            legend: {
                labels: {
                    colors: this.chartOptions.chart.foreColor
                }
            }
        };

        return this.createChart(containerId, options);
    }

    createPieChart(containerId, data, labels, colors = ['#7C83FD']) {
        const options = {
            ...this.chartOptions,
            chart: {
                ...this.chartOptions.chart,
                type: 'pie'
            },
            series: data,
            labels: labels,
            colors: colors,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: this.chartOptions.chart.foreColor
                        }
                    }
                }
            }],
            legend: {
                labels: {
                    colors: this.chartOptions.chart.foreColor
                }
            }
        };

        return this.createChart(containerId, options);
    }

    createDonutChart(containerId, data, labels, colors = ['#7C83FD']) {
        const options = {
            ...this.chartOptions,
            chart: {
                ...this.chartOptions.chart,
                type: 'donut'
            },
            series: data,
            labels: labels,
            colors: colors,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: this.chartOptions.chart.foreColor
                        }
                    }
                }
            }],
            legend: {
                labels: {
                    colors: this.chartOptions.chart.foreColor
                }
            }
        };

        return this.createChart(containerId, options);
    }

    createSemiDonutChart(containerId, data, labels, colors = ['#7C83FD']) {
        const options = {
            ...this.chartOptions,
            chart: {
                ...this.chartOptions.chart,
                type: 'donut'
            },
            plotOptions: {
                pie: {
                    startAngle: -90,
                    endAngle: 90,
                    offsetY: 10,
                    donut: {
                        size: '65%'
                    }
                }
            },
            grid: {
                padding: {
                    bottom: -100
                }
            },
            series: data,
            labels: labels,
            colors: colors,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: this.chartOptions.chart.foreColor
                        }
                    }
                }
            }],
            legend: {
                labels: {
                    colors: this.chartOptions.chart.foreColor
                }
            }
        };

        return this.createChart(containerId, options);
    }

    createAreaChart(containerId, data, categories, color = '#7C83FD') {
        const options = {
            ...this.chartOptions,
            chart: {
                ...this.chartOptions.chart,
                type: 'area',
                stacked: false,
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            series: [{
                name: 'Valores',
                data: data
            }],
            xaxis: {
                categories: categories,
                type: 'category',
                labels: {
                    style: {
                        colors: this.chartOptions.chart.foreColor
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: this.chartOptions.chart.foreColor
                    }
                }
            },
            colors: Array.isArray(color) ? color : [color],
            legend: {
                labels: {
                    colors: this.chartOptions.chart.foreColor
                }
            }
        };

        return this.createChart(containerId, options);
    }

    createChart(containerId, options) {
        const chart = new ApexCharts(document.querySelector(`#${containerId}`), options);
        chart.render();
        this.chartInstances[containerId] = chart;
        return chart;
    }
}
