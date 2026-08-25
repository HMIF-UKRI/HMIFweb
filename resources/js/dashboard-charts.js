import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;

window.DashboardCharts = {
    ganttChart: null,
    barChart: null,
    areaChart: null,
    donutChart: null,

    initGantt(elementId, events) {
        const el = document.getElementById(elementId);
        if (!el) return;

        if (this.ganttChart) {
            try {
                this.ganttChart.destroy();
            } catch (e) {
                console.warn('Gantt destroy warning:', e);
            }
            this.ganttChart = null;
        }

        if (!events || events.length === 0) {
            el.innerHTML = `
                <div class="flex flex-col items-center justify-center h-64 text-gray-500 border border-dashed border-white/10 rounded-2xl">
                    <i class="fa-solid fa-calendar-xmark text-3xl mb-2"></i>
                    <p class="text-xs font-bold uppercase tracking-wider">Belum ada linimasa kegiatan pada periode ini</p>
                </div>
            `;
            return;
        }

        const seriesData = events.map(ev => ({
            x: ev.title || 'Kegiatan',
            y: [
                new Date(ev.start).getTime(),
                new Date(ev.end).getTime()
            ],
            fillColor: ev.color || '#3b82f6',
            meta: ev
        }));

        const options = {
            series: [{ data: seriesData }],
            chart: {
                height: Math.max(260, events.length * 48),
                type: 'rangeBar',
                background: 'transparent',
                toolbar: { show: false },
                animations: { enabled: true, speed: 600 }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    distributed: true,
                    dataLabels: { hideOverflowingLabels: false },
                    borderRadius: 6,
                    barHeight: '65%'
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opt) {
                    try {
                        const meta = opt?.w?.config?.series?.[0]?.data?.[opt?.dataPointIndex]?.meta;
                        return meta ? `${meta.department} • ${meta.status_label}` : '';
                    } catch (e) {
                        return '';
                    }
                },
                style: {
                    colors: ['#ffffff'],
                    fontSize: '10px',
                    fontWeight: 700
                }
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    style: { colors: '#9ca3af', fontSize: '10px' },
                    datetimeUTC: false
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#ffffff', fontSize: '11px', fontWeight: 600 },
                    maxWidth: 180
                }
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.05)',
                xaxis: { lines: { show: true } },
                yaxis: { lines: { show: false } }
            },
            tooltip: {
                theme: 'dark',
                custom: function ({ seriesIndex, dataPointIndex, w }) {
                    try {
                        const meta = w?.config?.series?.[seriesIndex]?.data?.[dataPointIndex]?.meta;
                        if (!meta) return '';
                        return `
                            <div class="p-3 bg-gray-900 border border-white/10 rounded-xl shadow-xl text-xs space-y-1">
                                <p class="font-bold text-white text-sm">${meta.title}</p>
                                <p class="text-gray-400">Departemen: <span class="text-gray-200 font-semibold">${meta.department}</span></p>
                                <p class="text-gray-400">PIC: <span class="text-gray-200 font-semibold">${meta.pic}</span></p>
                                <p class="text-gray-400">Tanggal: <span class="text-gray-200 font-semibold">${meta.start_formatted}</span></p>
                                <p class="text-gray-400">Pendaftar: <span class="text-red-400 font-bold">${meta.participants_count} Peserta</span></p>
                                <div class="pt-1.5 flex items-center justify-between">
                                    <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase text-white" style="background-color: ${meta.color}">
                                        ${meta.status_label}
                                    </span>
                                    <a href="/admin/events/${meta.slug}" class="text-[10px] text-blue-400 hover:underline">Detail Event →</a>
                                </div>
                            </div>
                        `;
                    } catch (e) {
                        return '';
                    }
                }
            },
            legend: { show: false }
        };

        this.ganttChart = new ApexCharts(el, options);
        this.ganttChart.render();
    },

    initBar(elementId, categories, eventsCount, participantsCount) {
        const el = document.getElementById(elementId);
        if (!el) return;

        if (this.barChart) {
            try {
                this.barChart.destroy();
            } catch (e) {
                console.warn('Bar destroy warning:', e);
            }
            this.barChart = null;
        }

        const options = {
            series: [
                { name: 'Program Kerja', data: eventsCount || [] },
                { name: 'Partisipan', data: participantsCount || [] }
            ],
            chart: {
                type: 'bar',
                height: 280,
                background: 'transparent',
                toolbar: { show: false },
                animations: { enabled: true, speed: 600 }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 6
                }
            },
            colors: ['#ef4444', '#3b82f6'],
            dataLabels: { enabled: false },
            stroke: { show: true, width: 2, colors: ['transparent'] },
            xaxis: {
                categories: categories || [],
                labels: {
                    style: { colors: '#9ca3af', fontSize: '10px', fontWeight: 600 }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9ca3af', fontSize: '10px' }
                }
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.05)'
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                labels: { colors: '#d1d5db' },
                fontSize: '11px',
                markers: { radius: 12 }
            },
            tooltip: {
                theme: 'dark'
            }
        };

        this.barChart = new ApexCharts(el, options);
        this.barChart.render();
    },

    initArea(elementId, dates, registrations) {
        const el = document.getElementById(elementId);
        if (!el) return;

        if (this.areaChart) {
            try {
                this.areaChart.destroy();
            } catch (e) {
                console.warn('Area destroy warning:', e);
            }
            this.areaChart = null;
        }

        const options = {
            series: [
                { name: 'Pendaftar Kegiatan', data: registrations || [] }
            ],
            chart: {
                type: 'area',
                height: 240,
                background: 'transparent',
                toolbar: { show: false },
                animations: { enabled: true, speed: 600 }
            },
            colors: ['#dc2626'],
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [0, 95, 100]
                }
            },
            dataLabels: { enabled: false },
            xaxis: {
                categories: dates || [],
                labels: {
                    style: { colors: '#9ca3af', fontSize: '10px' },
                    rotate: -30
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9ca3af', fontSize: '10px' },
                    formatter: val => Math.floor(val)
                }
            },
            grid: {
                borderColor: 'rgba(255, 255, 255, 0.05)'
            },
            tooltip: {
                theme: 'dark'
            }
        };

        this.areaChart = new ApexCharts(el, options);
        this.areaChart.render();
    },

    initDonut(elementId, labels, series) {
        const el = document.getElementById(elementId);
        if (!el) return;

        if (this.donutChart) {
            try {
                this.donutChart.destroy();
            } catch (e) {
                console.warn('Donut destroy warning:', e);
            }
            this.donutChart = null;
        }

        const total = (series || []).reduce((acc, curr) => acc + curr, 0);

        if (total === 0) {
            el.innerHTML = `
                <div class="flex flex-col items-center justify-center h-64 text-gray-500 border border-dashed border-white/10 rounded-2xl">
                    <i class="fa-solid fa-chart-pie text-3xl mb-2"></i>
                    <p class="text-xs font-bold uppercase tracking-wider">Belum ada data pendaftar</p>
                </div>
            `;
            return;
        }

        const options = {
            series: series || [],
            labels: labels || [],
            chart: {
                type: 'donut',
                height: 260,
                background: 'transparent'
            },
            colors: ['#dc2626', '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#06b6d4'],
            stroke: {
                colors: ['#111827'],
                width: 2
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '72%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                color: '#9ca3af',
                                fontSize: '11px',
                                fontWeight: 700
                            },
                            value: {
                                show: true,
                                color: '#ffffff',
                                fontSize: '20px',
                                fontWeight: 900,
                                formatter: val => `${val} Org`
                            },
                            total: {
                                show: true,
                                label: 'Total Peserta',
                                color: '#9ca3af',
                                fontSize: '10px',
                                fontWeight: 700,
                                formatter: () => `${total} Org`
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                labels: { colors: '#d1d5db' },
                fontSize: '10px',
                markers: { radius: 12 }
            },
            tooltip: {
                theme: 'dark'
            }
        };

        this.donutChart = new ApexCharts(el, options);
        this.donutChart.render();
    }
};
