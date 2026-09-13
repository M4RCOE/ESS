import ApexCharts from "apexcharts";
class ApexChartCreator {
    public options;
    constructor() {
        this.options = {};
    }

    createSparkline(id, data, color, title) {
        const sparklineOptions = {
            chart: {
                id: id,
                type: 'line',
                height: 140,
                sparkline: { enabled: true },
                group: 'sparklines'
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
                style: { fontSize: '26px' }
            },
            colors: [color]
        };

        new ApexCharts(document.querySelector(`#${id}`), sparklineOptions).render();
    }

    createBarChart(id, seriesData, labels) {
        const barChartOptions = {
            chart: {
                type: 'bar',
                height: 250,
                width: '100%',
                stacked: true,
                foreColor: '#999',
            },
            plotOptions: {
                bar: {
                    dataLabels: { enabled: false },
                    columnWidth: '75%',
                    borderRadius: 7
                }
            },
            colors: ["#00C5A4", '#F3F2FC'],
            series: seriesData,
            labels: labels,
            xaxis: {
                axisBorder: { show: false },
                axisTicks: { show: false },
                crosshairs: { show: false },
                labels: { show: false, style: { fontSize: '14px' } }
            },
            grid: {
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: false } }
            },
            yaxis: {
                axisBorder: { show: false },
                labels: { show: false }
            },
            legend: {
                floating: true,
                position: 'top',
                horizontalAlign: 'right',
                offsetY: -36
            },
            title: {
                text: 'Web Statistics',
                align: 'left',
            },
            subtitle: {
                text: 'Sessions and Views'
            },
            tooltip: {
                shared: true,
                intersect: false
            }
        };

        new ApexCharts(document.querySelector(`#${id}`), barChartOptions).render();
    }

    createRadialBarChart(id, series, colors, title) {
        const radialBarOptions = {
            chart: {
                type: 'radialBar',
                height: 266,
                zoom: { enabled: false },
                offsetY: 20
            },
            colors: colors,
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    hollow: {
                        margin: 0,
                        size: '70%'
                    },
                    dataLabels: {
                        name: { show: false },
                        value: {
                            offsetY: 0,
                            fontSize: '22px',
                            show: true
                        }
                    },
                    track: {
                        background: '#f2f2f2',
                        strokeWidth: '97%'
                    }
                }
            },
            series: series,
            stroke: {
                lineCap: 'round'
            },
            title: {
                text: title,
                align: 'left',
                style: {
                    fontSize: '16px'
                }
            },
            legend: { show: false }
        };

        new ApexCharts(document.querySelector(`#${id}`), radialBarOptions).render();
    }
    createPieChart(id, series, labels, colors, title) {
        if (!id || !series || !labels) {
            console.error('Parámetros requeridos faltantes');
            return;
        }
        const pieChartOptions = {
            chart: {
                height: 350,
                type: 'pie',
            },
            plotOptions: {
                pie: {
                    dataLabels: {
                        offset: 0,
                        minAngleToShowLabel: 10
                    },
                    donut: {
                        size: '0%' // Elimina el hueco central para hacer un pie chart puro
                    }
                }
            },
            series: series,
            labels: labels,
            colors: colors,
            title: {
                text: title,
                align: 'center',
                style: {
                    fontSize: '16px'
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                itemMargin: {
                    horizontal: 5,
                    vertical: 5
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            tooltip: {
                y: {
                    formatter: function (value) {
                        return value + "%";
                    }
                }
            }
        };

        new ApexCharts(document.querySelector(`#${id}`), pieChartOptions).render();
    }
    createDonutChart(id, series, labels, colors, title) {
        const donutChartOptions = {
            chart: {
                height: 350,
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontWeight: 600,
                                color: undefined
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 700,
                                color: '#374151'
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                color: '#6B7280',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            colors: colors,
            series: series,
            labels: labels,
            title: {
                text: title,
                align: 'center',
                style: {
                    fontSize: '16px'
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        new ApexCharts(document.querySelector(`#${id}`), donutChartOptions).render();
    }

    createSemiDonutChart(id, series, labels, colors, title) {
        const semiDonutOptions = {
            chart: {
                height: 350,
                type: 'donut',
            },
            plotOptions: {
                pie: {
                    startAngle: -90,
                    endAngle: 90,
                    offsetY: 10,
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontWeight: 600,
                                offsetY: -5
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 700,
                                offsetY: 5,
                                color: '#374151'
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                color: '#6B7280',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            series: series,
            labels: labels,
            colors: colors,
            title: {
                text: title,
                align: 'center',
                style: {
                    fontSize: '16px'
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        new ApexCharts(document.querySelector(`#${id}`), semiDonutOptions).render();
    }

    createAreaChart(selectorId, seriesData, labelData) {
        if (!seriesData || !Array.isArray(seriesData) || seriesData.length === 0) {
            console.error('Error: No valid series data provided!');
            return;
        }
        if (!labelData || !Array.isArray(labelData) || labelData.length === 0) {
            console.error('Error: No valid label data provided!');
            return;
        }

        const options = {
            chart: {
                type: 'area',
                height: 421,
                stacked: true,
                zoom: { enabled: false },
                offsetY: 30,
                toolbar: { show: false }
            },
            stroke: {
                curve: 'smooth'
            },
            colors: ['#A5B4FC', '#93C5FD'],
            series: seriesData,
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    opacityFrom: 0.8,
                    opacityTo: 0.4,
                    stops: [0, 100]
                }
            },
            title: {
                text: 'Visitor Insights',
                align: 'left',
                offsetX: 20,
                style: { color: '#374151' }
            },
            subtitle: {
                text: 'Adwords Statistics',
                offsetX: 20,
                style: { color: '#6B7280' }
            },
            xaxis: {
                type: 'datetime',
                categories: labelData,
                labels: { style: { colors: '#6B7280' } }
            },
            yaxis: {
                show: false
            },
            markers: {
                size: 0
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                show: false
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                offsetY: -10
            },
            tooltip: {
                shared: true,
                intersect: false
            }
        };

        new ApexCharts(document.querySelector(`#${selectorId}`), options).render();
    }
}
