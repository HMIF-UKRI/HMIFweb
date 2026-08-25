<x-app-layout>
    <x-slot name="meta">
        @include('components._meta', [
            'title' => 'Dashboard Kontrol & Analitik — HMIF UKRI',
            'description' => 'Pusat komando dan visualisasi data kinerja organisasi HMIF UKRI.',
            'image' => asset('images/banner-kegiatan.png'),
            'url' => url()->current(),
        ])
    </x-slot>

    <x-slot name="header_title">Dashboard</x-slot>

    <div x-data="dashboardAnalytics()" x-init="init()" class="space-y-6 pb-16">

        {{-- ===== HEADER COMMAND CENTER ===== --}}
        <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-gray-900/60 backdrop-blur-xl px-6 py-5 md:px-8 md:py-6">
            {{-- Background Blob --}}
            <div class="pointer-events-none absolute -right-20 -top-20 h-80 w-80 rounded-full bg-red-600/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-16 -left-16 h-64 w-64 rounded-full bg-blue-600/5 blur-3xl"></div>

            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                {{-- Title Block --}}
                <div class="space-y-1.5">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-red-500/30 bg-red-600/15 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-widest text-red-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500 animate-pulse"></span>
                            Command Center
                        </span>
                        <span class="text-[11px] font-semibold text-gray-400" x-text="activePeriodName ? 'Kabinet ' + activePeriodName : ''"></span>
                    </div>
                    <h1 class="text-2xl font-black tracking-tight text-white md:text-3xl">
                        Dashboard <span class="italic text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-rose-400">HMIF</span>
                    </h1>
                    <p class="text-xs text-gray-400 leading-relaxed max-w-xl">
                        Monitoring terpadu program kerja, partisipan, dan publikasi HMIF UKRI secara real-time.
                    </p>
                </div>

                {{-- Controls --}}
                <div class="flex flex-wrap items-center gap-2.5">
                    {{-- Period Selector --}}
                    <div class="relative">
                        <select x-model="periodId" @change="fetchData()"
                            class="appearance-none rounded-xl border border-white/10 bg-black/40 pl-3.5 pr-8 py-2 text-[11px] font-bold text-white outline-none transition hover:border-white/20 focus:border-red-500/60 cursor-pointer">
                            @foreach ($summary['periods'] as $period)
                                <option value="{{ $period->id }}" class="bg-gray-950 text-white"
                                    {{ $period->id === ($summary['active_period']?->id ?? null) ? 'selected' : '' }}>
                                    {{ $period->cabinet_name }} ({{ $period->period_range }})
                                </option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[9px] text-gray-500"></i>
                    </div>

                    {{-- Time Range Tabs --}}
                    <div class="flex items-center rounded-xl border border-white/10 bg-black/40 p-0.5 gap-0.5">
                        @foreach ([['7d','7H'], ['30d','30H'], ['90d','90H'], ['1y','1T']] as [$val, $lbl])
                            <button type="button" @click="setTimeRange('{{ $val }}')"
                                :class="timeRange === '{{ $val }}' ? 'bg-red-600 text-white shadow-red-700/30 shadow-md' : 'text-gray-500 hover:text-white'"
                                class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-wider transition-all duration-200">
                                {{ $lbl }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Refresh --}}
                    <button type="button" @click="fetchData()" :disabled="loading" title="Perbarui data"
                        class="flex h-8 w-8 items-center justify-center rounded-xl border border-white/10 bg-black/40 text-gray-400 transition hover:border-red-500/50 hover:text-white">
                        <i class="fa-solid fa-arrows-rotate text-[11px]" :class="loading ? 'fa-spin text-red-500' : ''"></i>
                    </button>
                </div>
            </div>
        </div>


        {{-- ===== KPI CARDS ROW ===== --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">

            {{-- Card: Total Anggota --}}
            <div class="group relative overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-blue-500/30 hover:bg-gray-900/60">
                <div class="flex items-start justify-between">
                    <div class="space-y-0.5">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Total Anggota</p>
                    </div>
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-blue-500/20 bg-blue-500/10 text-blue-400">
                        <i class="fa-solid fa-users text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-white" x-text="kpi.total_members"></span>
                    <span class="text-[11px] font-medium text-gray-500">orang</span>
                </div>
                <div class="mt-3 flex items-center gap-2 border-t border-white/5 pt-3">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                        <i class="fa-solid fa-circle-check text-[8px]"></i>
                        <span x-text="kpi.active_members"></span> aktif
                    </span>
                    <span class="text-gray-700">·</span>
                    <span class="text-[10px] text-gray-500" x-text="(kpi.total_members - kpi.active_members) + ' non-aktif'"></span>
                </div>
            </div>

            {{-- Card: Program Kerja --}}
            <div class="group relative overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-red-500/30 hover:bg-gray-900/60">
                <div class="flex items-start justify-between">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Program Kerja</p>
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-red-500/20 bg-red-500/10 text-red-400">
                        <i class="fa-solid fa-calendar-check text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-white" x-text="kpi.total_events"></span>
                    <span class="text-[11px] font-medium text-gray-500">kegiatan</span>
                </div>
                <div class="mt-3 border-t border-white/5 pt-3 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] text-gray-500">Penyelesaian</span>
                        <span class="text-[10px] font-black text-emerald-400" x-text="kpi.completion_rate + '%'"></span>
                    </div>
                    <div class="h-1 w-full overflow-hidden rounded-full bg-white/5">
                        <div class="h-full rounded-full bg-gradient-to-r from-red-600 to-emerald-500 transition-all duration-700"
                            :style="'width: ' + kpi.completion_rate + '%'"></div>
                    </div>
                </div>
            </div>

            {{-- Card: Partisipan Event --}}
            <div class="group relative overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-500/30 hover:bg-gray-900/60">
                <div class="flex items-start justify-between">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">Partisipan Event</p>
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400">
                        <i class="fa-solid fa-id-card-clip text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-white" x-text="kpi.total_registrations"></span>
                    <span class="text-[11px] font-medium text-gray-500">pendaftar</span>
                </div>
                <div class="mt-3 flex items-center gap-2 border-t border-white/5 pt-3">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-400">
                        <i class="fa-solid fa-award text-[8px]"></i>
                        <span x-text="kpi.certificates_sent"></span> sertifikat
                    </span>
                    <span class="text-gray-700">·</span>
                    <span class="text-[10px] text-gray-500" x-text="kpi.certificate_rate + '% terkirim'"></span>
                </div>
            </div>

            {{-- Card: HMIF Insight --}}
            <div class="group relative overflow-hidden rounded-2xl border border-white/8 bg-gray-900/40 p-5 backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-purple-500/30 hover:bg-gray-900/60">
                <div class="flex items-start justify-between">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gray-500">HMIF Insight</p>
                    <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl border border-purple-500/20 bg-purple-500/10 text-purple-400">
                        <i class="fa-solid fa-book-open-reader text-sm"></i>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-1.5">
                    <span class="text-3xl font-black text-white" x-text="kpi.total_blogs"></span>
                    <span class="text-[11px] font-medium text-gray-500">artikel</span>
                </div>
                <div class="mt-3 flex items-center gap-2 border-t border-white/5 pt-3">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-red-400">
                        <i class="fa-solid fa-eye text-[8px]"></i>
                        <span x-text="Number(kpi.total_blog_views).toLocaleString('id-ID')"></span> views
                    </span>
                    <span class="text-gray-700">·</span>
                    <span class="text-[10px] text-gray-500">Publikasi aktif</span>
                </div>
            </div>

        </div>


        {{-- ===== GANTT TIMELINE & DEMOGRAPHICS ===== --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

            {{-- Gantt Chart (8 cols) --}}
            <div class="rounded-2xl border border-white/8 bg-gray-900/40 backdrop-blur-sm lg:col-span-8">
                <div class="border-b border-white/5 px-6 py-4">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="h-2 w-2 rounded-full bg-red-500 flex-shrink-0"></span>
                                <h2 class="text-sm font-black uppercase tracking-wider text-white">Linimasa Program Kerja</h2>
                            </div>
                            <p class="text-[11px] text-gray-400 pl-4">Jadwal pelaksanaan proker sepanjang periode kepengurusan.</p>
                        </div>
                        {{-- Department Filter --}}
                        <div class="flex flex-wrap gap-1.5 sm:justify-end">
                            <button type="button" @click="filterDepartment('')"
                                :class="departmentId === '' ? 'bg-red-600 text-white' : 'bg-white/5 text-gray-400 hover:bg-white/8 hover:text-gray-200'"
                                class="rounded-lg px-2.5 py-1 text-[10px] font-bold uppercase transition">
                                Semua
                            </button>
                            @foreach ($summary['departments'] as $dept)
                                <button type="button" @click="filterDepartment('{{ $dept->id }}')"
                                    :class="departmentId == '{{ $dept->id }}' ? 'bg-red-600 text-white' : 'bg-white/5 text-gray-400 hover:bg-white/8 hover:text-gray-200'"
                                    class="rounded-lg px-2.5 py-1 text-[10px] font-bold uppercase transition">
                                    {{ $dept->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="px-6 py-5">
                    <div id="gantt-chart" class="min-h-64"></div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-white/5 px-6 py-3.5">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-blue-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-blue-500"></span> Upcoming
                        </span>
                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-amber-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Ongoing
                        </span>
                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Completed
                        </span>
                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-red-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span> Cancelled
                        </span>
                    </div>
                    <a href="{{ route('admin.events.index') }}"
                        class="flex items-center gap-1.5 text-[10px] font-bold text-gray-500 transition hover:text-white">
                        Kelola Semua Kegiatan <i class="fa-solid fa-arrow-right-long text-[9px]"></i>
                    </a>
                </div>
            </div>

            {{-- Demographics Donut (4 cols) --}}
            <div class="rounded-2xl border border-white/8 bg-gray-900/40 backdrop-blur-sm lg:col-span-4 flex flex-col">
                <div class="border-b border-white/5 px-6 py-4">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="h-2 w-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                        <h2 class="text-sm font-black uppercase tracking-wider text-white">Demografi Partisipan</h2>
                    </div>
                    <p class="text-[11px] text-gray-400 pl-4">Sebaran pendaftar kegiatan berdasarkan kategori.</p>
                </div>

                <div class="flex-1 px-6 py-5">
                    <div id="demographics-chart" class="min-h-64"></div>
                </div>

                <div class="border-t border-white/5 px-6 py-3.5 text-center">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">
                        Integrasi Data Presensi &amp; Pendaftaran
                    </p>
                </div>
            </div>

        </div>


        {{-- ===== BAR CHART & AREA CHART ===== --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            {{-- Bar Chart: Kinerja per Departemen --}}
            <div class="rounded-2xl border border-white/8 bg-gray-900/40 backdrop-blur-sm">
                <div class="border-b border-white/5 px-6 py-4">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                        <h2 class="text-sm font-black uppercase tracking-wider text-white">Kinerja per Departemen</h2>
                    </div>
                    <p class="text-[11px] text-gray-400 pl-4">Total proker dan partisipasi peserta antar departemen.</p>
                </div>
                <div class="px-6 py-5">
                    <div id="department-bar-chart" class="min-h-64"></div>
                </div>
            </div>

            {{-- Area Chart: Tren Pendaftaran --}}
            <div class="rounded-2xl border border-white/8 bg-gray-900/40 backdrop-blur-sm">
                <div class="border-b border-white/5 px-6 py-4">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="h-2 w-2 rounded-full bg-red-500 flex-shrink-0"></span>
                        <h2 class="text-sm font-black uppercase tracking-wider text-white">Tren Pendaftaran Peserta</h2>
                    </div>
                    <p class="text-[11px] text-gray-400 pl-4">Akumulasi peserta yang mendaftar sesuai rentang waktu terpilih.</p>
                </div>
                <div class="px-6 py-5">
                    <div id="trends-area-chart" class="min-h-64"></div>
                </div>
            </div>

        </div>


        {{-- ===== ACTIVITY STREAM & QUICK ACTIONS ===== --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

            {{-- Activity Stream (7 cols) --}}
            <div class="rounded-2xl border border-white/8 bg-gray-900/40 backdrop-blur-sm lg:col-span-7">
                <div class="border-b border-white/5 px-6 py-4">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="h-2 w-2 rounded-full bg-amber-500 flex-shrink-0"></span>
                        <h2 class="text-sm font-black uppercase tracking-wider text-white">Aktivitas Sistem Terbaru</h2>
                    </div>
                    <p class="text-[11px] text-gray-400 pl-4">Log pendaftaran kegiatan, rilis artikel, dan event terkini.</p>
                </div>

                <div class="px-6 py-4 space-y-2">
                    <template x-if="activities.length === 0">
                        <div class="flex flex-col items-center justify-center py-14 text-gray-600">
                            <i class="fa-solid fa-clock-rotate-left text-3xl mb-3"></i>
                            <p class="text-xs font-bold uppercase tracking-wider">Belum ada aktivitas tercatat</p>
                        </div>
                    </template>

                    <template x-for="(act, idx) in activities" :key="idx">
                        <div class="flex items-center justify-between gap-3 rounded-xl border border-white/5 bg-white/[0.02] px-3.5 py-3 transition hover:bg-white/[0.04]">
                            <div class="flex items-center gap-3 max-w-[70%]">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg border text-xs"
                                    :class="act.badge_color">
                                    <i class="fa-solid" :class="act.icon"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-xs font-semibold text-white" x-text="act.title"></p>
                                    <p class="truncate text-[10px] text-gray-500" x-text="act.subtitle"></p>
                                </div>
                            </div>
                            <span class="flex-shrink-0 text-[10px] font-medium text-gray-600" x-text="act.time_ago"></span>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Quick Actions (5 cols) --}}
            <div class="rounded-2xl border border-white/8 bg-gray-900/40 backdrop-blur-sm lg:col-span-5">
                <div class="border-b border-white/5 px-6 py-4">
                    <div class="flex items-center gap-2 mb-0.5">
                        <span class="h-2 w-2 rounded-full bg-purple-500 flex-shrink-0"></span>
                        <h2 class="text-sm font-black uppercase tracking-wider text-white">Aksi Cepat</h2>
                    </div>
                    <p class="text-[11px] text-gray-400 pl-4">Pintasan navigasi ke modul utama HMIFweb.</p>
                </div>

                <div class="p-5 grid grid-cols-2 gap-3">
                    {{-- Primary Actions --}}
                    <a href="{{ route('admin.events.create') }}"
                        class="group flex flex-col gap-3 rounded-xl border border-red-600/30 bg-red-600/10 p-4 transition-all hover:border-red-500/60 hover:bg-red-600/20">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-600/20 text-red-400 group-hover:bg-red-600/30 transition">
                            <i class="fa-solid fa-calendar-plus text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-white">Buat Event</p>
                            <p class="text-[10px] text-gray-500">Tambah agenda baru</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.blogs.create') }}"
                        class="group flex flex-col gap-3 rounded-xl border border-purple-600/30 bg-purple-600/10 p-4 transition-all hover:border-purple-500/60 hover:bg-purple-600/20">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-purple-600/20 text-purple-400 group-hover:bg-purple-600/30 transition">
                            <i class="fa-solid fa-pen-nib text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-white">Tulis Artikel</p>
                            <p class="text-[10px] text-gray-500">Publikasi jurnal</p>
                        </div>
                    </a>

                    {{-- Secondary Actions --}}
                    @foreach ([
                        ['admin.members.index', 'fa-users', 'text-blue-400', 'Anggota', 'Direktori anggota'],
                        ['admin.managements.index', 'fa-sitemap', 'text-emerald-400', 'Pengurus', 'Struktur kabinet'],
                        ['admin.periods.index', 'fa-clock-rotate-left', 'text-amber-400', 'Periode', 'Atur kepengurusan'],
                        ['admin.departments.index', 'fa-building-columns', 'text-cyan-400', 'Departemen', 'Master bidang'],
                    ] as [$route, $icon, $color, $title, $sub])
                        <a href="{{ route($route) }}"
                            class="group flex flex-col gap-3 rounded-xl border border-white/8 bg-white/[0.03] p-4 transition-all hover:border-white/15 hover:bg-white/[0.06]">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/5 {{ $color }} transition">
                                <i class="fa-solid {{ $icon }} text-sm"></i>
                            </div>
                            <div>
                                <p class="text-xs font-black text-white">{{ $title }}</p>
                                <p class="text-[10px] text-gray-500">{{ $sub }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    @push('scripts')
    <script>
        function dashboardAnalytics() {
            return {
                loading: false,
                periodId: '{{ $summary['active_period']?->id ?? '' }}',
                activePeriodName: '{{ $summary['active_period']?->cabinet_name ?? '' }}',
                timeRange: '30d',
                departmentId: '',
                kpi: @json($summary['kpi']),
                gantt: @json($summary['gantt_timeline']),
                departmentPerformance: @json($summary['department_performance']),
                trends: @json($summary['trends']),
                demographics: @json($summary['demographics']),
                activities: @json($summary['recent_activities']),

                init() {
                    const tryRender = (attempts = 0) => {
                        if (window.DashboardCharts && window.ApexCharts) {
                            this.renderAllCharts();
                        } else if (attempts < 50) {
                            setTimeout(() => tryRender(attempts + 1), 50);
                        }
                    };
                    this.$nextTick(() => tryRender());
                },

                renderAllCharts() {
                    if (!window.DashboardCharts) return;
                    window.DashboardCharts.initGantt('gantt-chart', this.gantt);
                    window.DashboardCharts.initBar(
                        'department-bar-chart',
                        this.departmentPerformance.categories,
                        this.departmentPerformance.events_count,
                        this.departmentPerformance.participants_count
                    );
                    window.DashboardCharts.initArea(
                        'trends-area-chart',
                        this.trends.dates,
                        this.trends.registrations
                    );
                    window.DashboardCharts.initDonut(
                        'demographics-chart',
                        this.demographics.labels,
                        this.demographics.series
                    );
                },

                setTimeRange(range) {
                    this.timeRange = range;
                    this.fetchData();
                },

                filterDepartment(deptId) {
                    this.departmentId = deptId;
                    this.fetchGanttOnly();
                },

                async fetchData() {
                    this.loading = true;
                    try {
                        const params = new URLSearchParams({
                            period_id: this.periodId,
                            time_range: this.timeRange,
                            department_id: this.departmentId,
                        });
                        const res = await fetch(`/admin/dashboard/analytics?${params.toString()}`);
                        const json = await res.json();
                        if (json.status === 'success' && json.data) {
                            this.kpi = json.data.kpi;
                            this.gantt = json.data.gantt_timeline;
                            this.departmentPerformance = json.data.department_performance;
                            this.trends = json.data.trends;
                            this.demographics = json.data.demographics;
                            this.activities = json.data.recent_activities;
                            if (json.data.active_period) {
                                this.activePeriodName = json.data.active_period.cabinet_name;
                            }
                            this.renderAllCharts();
                        }
                    } catch (err) {
                        console.error('Dashboard fetch error:', err);
                    } finally {
                        this.loading = false;
                    }
                },

                async fetchGanttOnly() {
                    try {
                        const params = new URLSearchParams({
                            period_id: this.periodId,
                            department_id: this.departmentId,
                        });
                        const res = await fetch(`/admin/dashboard/gantt?${params.toString()}`);
                        const json = await res.json();
                        if (json.status === 'success' && json.data) {
                            this.gantt = json.data;
                            if (window.DashboardCharts) {
                                window.DashboardCharts.initGantt('gantt-chart', this.gantt);
                            }
                        }
                    } catch (err) {
                        console.error('Gantt fetch error:', err);
                    }
                },
            };
        }
    </script>
    @endpush

</x-app-layout>
