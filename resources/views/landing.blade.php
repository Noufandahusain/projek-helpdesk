@extends('layouts.app')

@section('title', 'Helptify Overview')

@section('content')
    <div class="relative overflow-hidden bg-gradient-to-b from-slate-50 via-white to-slate-100">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute -top-32 -left-12 w-72 h-72 bg-blue-200/40 rounded-full blur-3xl"></div>
            <div class="absolute top-24 -right-10 w-80 h-80 bg-indigo-300/30 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-1/3 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
        </div>

<main class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center animate-fade-in">
        <div class="space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-blue-100 bg-blue-50 text-blue-700 text-sm font-semibold animate-pulse-soft">
                <span class="h-2 w-2 rounded-full bg-blue-500 animate-pulse"></span>
                Layanan kampus yang sigap
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight text-slate-900 animate-slide-up">
                Satu pintu laporan <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-indigo-600">fasilitas kampus</span>
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl animate-slide-up" style="animation-delay: .1s">
                Kirim keluhan, pantau progres, dan dapatkan update real-time. Platform ini dibuat untuk mempermudah mahasiswa, staf, dan tim fasilitas berkolaborasi tanpa ribet.
            </p>
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 animate-slide-up" style="animation-delay: .15s">
                <a
                    href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-6 py-3 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/25 hover:shadow-blue-600/30 hover:-translate-y-0.5 transition"
                >
                    Masuk & mulai
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M5 12h14"></path>
                                <path d="m13 6 6 6-6 6"></path>
                            </svg>
                        </a>
                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-lg border border-slate-200 bg-white text-slate-800 font-semibold hover:border-blue-200 hover:bg-blue-50 transition shadow-sm"
                        >
                            Buat akun baru
                        </a>
                    </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 animate-slide-up" style="animation-delay: .2s">
                <div class="p-4 rounded-xl bg-white/70 backdrop-blur border border-slate-200 shadow-sm">
                    <p class="text-sm text-slate-500">Respon awal rata-rata</p>
                    <p class="text-2xl font-bold text-slate-900"> <span class="text-blue-600"> &lt; 1</span> jam</p>
                </div>
                <div class="p-4 rounded-xl bg-white/70 backdrop-blur border border-slate-200 shadow-sm">
                            <p class="text-sm text-slate-500">Update status otomatis</p>
                            <p class="text-2xl font-bold text-slate-900">Realtime</p>
                        </div>
                        <div class="p-4 rounded-xl bg-white/70 backdrop-blur border border-slate-200 shadow-sm">
                            <p class="text-sm text-slate-500">Pengguna aktif</p>
                            <p class="text-2xl font-bold text-slate-900">Mahasiswa & admin</p>
                        </div>
                    </div>
                </div>

                <div class="relative animate-slide-up" style="animation-delay: .25s">
                    <div class="absolute -inset-3 bg-gradient-to-br from-blue-500/20 to-indigo-500/10 blur-2xl rounded-3xl"></div>
                    <div
                        class="relative bg-white rounded-3xl border border-slate-200 shadow-2xl shadow-blue-500/10 overflow-hidden"
                        x-data="ticketFeed()"
                        x-init="start()"
                    >
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">Monitoring</p>
                                <p class="text-xl font-bold text-slate-900">Tiket fasilitas hari ini</p>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700">Live view</span>
                        </div>
                        <div class="p-6">
                            <div
                                class="relative overflow-hidden"
                                :style="{ height: `${containerHeight()}px` }"
                            >
                                <template x-for="(ticket, index) in visible" :key="ticket.id">
                                    <div
                                        class="absolute left-0 right-0 flex items-start gap-3 p-4 rounded-xl border border-slate-100 bg-slate-50/60 shadow-sm transition duration-500 ease-out"
                                        :style="itemStyle(index, ticket.isNew)"
                                        x-transition:enter="opacity-0"
                                        x-transition:enter-end="opacity-100"
                                        x-transition:leave="opacity-0 translate-y-4"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                    >
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white font-bold flex items-center justify-center">
                                            <span x-text="ticket.initial"></span>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-slate-900" x-text="ticket.title"></p>
                                            <p class="text-sm text-slate-500" x-text="ticket.time"></p>
                                        </div>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold"
                                            :class="statusClasses[ticket.status] || 'bg-slate-100 text-slate-800'"
                                            x-text="ticket.status"
                                        ></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                            <div class="flex items-center justify-between text-sm text-slate-700">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Progress perbaikan bergerak
                                </div>
                                <span class="font-semibold text-blue-600">Terhubung dengan admin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <div class="grid lg:grid-cols-3 gap-6 animate-fade-in" style="animation-delay: .1s">
                @php
                    $features = [
                        [
                            'title' => 'Pengajuan kilat',
                            'desc' => 'Formulir ringkas dengan foto & lokasi sehingga tim langsung tahu apa yang perlu dibantu.',
                            'icon' => '<path d="M5 12h14"></path><path d="M12 5l7 7-7 7"></path>',
                        ],
                        [
                            'title' => 'Pantau progres',
                            'desc' => 'Status tiket transparan dari Open sampai Resolved, lengkap dengan catatan admin.',
                            'icon' => '<path d="M5 3v4"></path><path d="M5 17v4"></path><rect x="9" y="5" width="13" height="4" rx="2"></rect><rect x="9" y="15" width="13" height="4" rx="2"></rect><path d="M5 11h4"></path><path d="M5 21h4"></path>',
                        ],
                        [
                            'title' => 'Notifikasi cerdas',
                            'desc' => 'Dapatkan notifikasi saat tiket Anda diproses, ditugaskan, atau selesai.',
                            'icon' => '<path d="M15 17h5l-1.403-1.403A2 2 0 0 1 18 14.172V11a6 6 0 1 0-12 0v3.172a2 2 0 0 1-.597 1.425L4 17h5"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path>',
                        ],
                    ];
                @endphp
                @foreach ($features as $feature)
                    <div class="p-6 rounded-2xl border border-slate-200 bg-white shadow-sm hover:-translate-y-1 hover:shadow-lg transition">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center mb-4 shadow-md shadow-blue-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                {!! $feature['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-slate-600">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <div class="rounded-3xl border border-slate-200 bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-900 text-white overflow-hidden">
                <div class="grid lg:grid-cols-2 gap-0">
                    <div class="p-10 lg:p-14 space-y-6">
                        <p class="text-sm uppercase tracking-wide text-indigo-200 font-semibold">Cara kerja</p>
                        <h2 class="text-3xl sm:text-4xl font-bold">Langkah praktis untuk mulai pakai</h2>
                        <div class="space-y-4">
                            @php
                                $steps = [
                                    ['title' => 'Buat akun atau login', 'detail' => 'Mahasiswa dan admin masuk ke sistem sesuai peran masing-masing.'],
                                    ['title' => 'Kirim tiket dengan detail jelas', 'detail' => 'Cantumkan lokasi, kategori, dan foto agar tim cepat menindaklanjuti.'],
                                    ['title' => 'Terima update & selesai', 'detail' => 'Pantau progres, balas komentar, dan simpan laporan selesai.'],
                                ];
                            @endphp
                            @foreach ($steps as $index => $step)
                                <div class="flex gap-4 items-start">
                                    <div class="w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-lg font-semibold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <p class="text-lg font-semibold">{{ $step['title'] }}</p>
                                        <p class="text-sm text-indigo-100">{{ $step['detail'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex flex-wrap gap-3 pt-2">
                            <a href="{{ route('register') }}" class="px-5 py-3 rounded-lg bg-white text-slate-900 font-semibold hover:bg-indigo-50 transition">
                                Daftar sebagai mahasiswa
                            </a>
                            <a href="{{ route('login') }}" class="px-5 py-3 rounded-lg border border-white/30 text-white font-semibold hover:border-white/60 transition">
                                Login admin / petugas
                            </a>
                        </div>
                    </div>
                    <div class="relative bg-white/5 border-l border-white/10 p-10 lg:p-14">
                        <div class="absolute inset-6 rounded-3xl bg-gradient-to-br from-blue-500/10 to-indigo-500/10 blur-3xl"></div>
                        <div class="relative space-y-5">
                            <div class="flex items-center justify-between">
                                <p class="text-sm text-indigo-100">Status ringkas</p>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full bg-white/10">Demo live</span>
                            </div>
                            <div class="space-y-3">
                                @php
                                    $progress = [
                                        ['label' => 'Open', 'value' => 26, 'color' => 'from-amber-400 to-orange-500'],
                                        ['label' => 'In Progress', 'value' => 41, 'color' => 'from-blue-400 to-indigo-500'],
                                        ['label' => 'Resolved', 'value' => 33, 'color' => 'from-emerald-400 to-green-500'],
                                    ];
                                @endphp
                                @foreach ($progress as $item)
                                    <div
                                        class="p-4 rounded-xl bg-white/10 border border-white/10"
                                        x-data="{
                                            seen: false,
                                            init() {
                                                const observer = new IntersectionObserver(
                                                    (entries, obs) => {
                                                        entries.forEach(entry => {
                                                            if (entry.isIntersecting) {
                                                                this.seen = true;
                                                                obs.disconnect();
                                                            }
                                                        });
                                                    },
                                                    { threshold: 0.3 }
                                                );
                                                observer.observe(this.$el);
                                            }
                                        }"
                                    >
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="font-semibold">{{ $item['label'] }}</p>
                                            <span class="text-sm font-semibold">{{ $item['value'] }}%</span>
                                        </div>
                                        <div class="w-full h-2.5 rounded-full bg-white/10 overflow-hidden">
                                            <div
                                                class="h-full w-0 rounded-full bg-gradient-to-r {{ $item['color'] }} transition-all duration-1000 ease-out"
                                                :class="seen ? 'animate-fill-bar' : ''"
                                                style="--target: {{ $item['value'] }}%; width: 0%;"
                                            ></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="p-4 rounded-xl bg-white/10 border border-white/10">
                                <p class="text-sm text-indigo-100 mb-2">Pengalaman pengguna</p>
                                <p class="text-lg font-semibold">"Sekarang laporan fasilitas jadi rapi. Admin cepat kasih update, dan semua progres bisa saya cek dari dashboard mahasiswa."</p>
                                <p class="text-sm text-indigo-200 mt-2">- Mahasiswa, Fakultas Teknik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6 p-8 rounded-3xl border border-slate-200 bg-white shadow-lg shadow-blue-500/10">
                <div>
                    <p class="text-sm font-semibold text-blue-600">Siap memulai?</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mt-2">Buka tiket pertama Anda dalam hitungan menit</h3>
                    <p class="text-slate-600 mt-2">Login bila sudah punya akun, atau daftar dan jelajahi dashboard mahasiswa.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('login') }}" class="px-5 py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                        Pergi ke Login
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-3 rounded-lg border border-slate-200 text-slate-800 font-semibold hover:border-blue-200 hover:text-blue-700 transition">
                        Buat Akun
                    </a>
                </div>
            </div>
        </section>
    </div>

    <script>
        function ticketFeed() {
            return {
                statusClasses: {
                    'Open': 'bg-amber-100 text-amber-800',
                    'In Progress': 'bg-blue-100 text-blue-800',
                    'Resolved': 'bg-emerald-100 text-emerald-800',
                },
                itemHeight: 96,
                gap: 12,
                pool: [
                    { title: 'AC ruang 3.12 tidak dingin', status: 'Open', time: 'Baru saja' },
                    { title: 'Proyektor aula berkedip', status: 'In Progress', time: '35 menit lalu' },
                    { title: 'Lampu lorong padam', status: 'Resolved', time: '2 jam lalu' },
                ],
                visible: [],
                intervalId: null,
                pointer: 0,
                start() {
                    this.visible = this.pool.slice(0, 3).map(t => this.decorate(t));
                    document.addEventListener('visibilitychange', () => {
                        if (document.visibilityState === 'visible') {
                            this.visible = this.visible.map(t => ({ ...t, isNew: false }));
                        }
                    });
                    this.intervalId = setInterval(() => {
                        const next = this.decorate(this.pool[this.pointer]);
                        next.isNew = true;
                        this.pointer = (this.pointer + 1) % this.pool.length;
                        this.visible.unshift(next);
                        if (this.visible.length > 4) {
                            this.visible.pop();
                        }
                        requestAnimationFrame(() => {
                            requestAnimationFrame(() => {
                                if (this.visible[0]) this.visible[0].isNew = false;
                            });
                        });
                        setTimeout(() => {
                            if (this.visible[0]) this.visible[0].isNew = false;
                        }, 100);
                    }, 2200);
                },
                decorate(ticket) {
                    const id = typeof crypto !== 'undefined' && crypto.randomUUID
                        ? crypto.randomUUID()
                        : `id-${Date.now()}-${Math.random().toString(16).slice(2)}`;
                    return { ...ticket, id, initial: ticket.title.trim().charAt(0).toUpperCase(), isNew: false };
                },
                containerHeight() {
                    return 3 * this.itemHeight + 2 * this.gap;
                },
                itemStyle(index, isNew) {
                    const enteringOffset = -(this.itemHeight + this.gap);
                    return {
                        top: `${index * (this.itemHeight + this.gap)}px`,
                        transform: isNew ? `translateY(${enteringOffset}px)` : 'translateY(0)',
                        transition: 'top 400ms ease, opacity 250ms ease, transform 400ms ease',
                    };
                },
            };
        }
    </script>
@endsection
