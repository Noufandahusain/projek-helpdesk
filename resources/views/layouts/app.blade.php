<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Campus Helpdesk')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-50 font-['Instrument_Sans'] antialiased">
    <nav class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="5" y="3" width="14" height="18" rx="2"></rect>
                            <path d="M9 21v-4h6v4"></path>
                            <path d="M9 7h6"></path>
                            <path d="M9 11h6"></path>
                            <path d="M9 15h6"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-slate-900">Campus Helpdesk</span>
                </div>

                @php
                    $navItems = [
                        ['label' => 'Dashboard', 'route' => 'student.dashboard'],
                        ['label' => 'Create Ticket', 'route' => 'student.tickets.create'],
                        ['label' => 'My Tickets', 'route' => 'student.tickets.index'],
                    ];
                @endphp

                <div class="hidden md:flex items-center gap-3" x-data="{ open: false }">
                    @auth
                        @foreach ($navItems as $item)
                            <a
                                href="{{ route($item['route']) }}"
                                class="px-4 py-2 font-medium rounded-lg transition {{ request()->routeIs($item['route']) ? 'text-blue-600 bg-blue-50' : 'text-slate-700 hover:bg-slate-100' }}"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                        <div class="relative">
                            <button
                                type="button"
                                class="px-3 py-2 text-sm font-semibold text-slate-700 bg-slate-100 rounded-lg flex items-center gap-2"
                                @click="open = !open"
                            >
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </button>
                            <div
                                x-show="open"
                                x-cloak
                                @click.outside="open = false"
                                class="absolute right-0 mt-2 w-40 bg-white border border-slate-200 rounded-lg shadow-lg py-2"
                            >
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-slate-700 hover:bg-slate-100 flex items-center gap-2"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <path d="M16 17l5-5-5-5"></path>
                                            <path d="M21 12H9"></path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 font-medium rounded-lg transition text-blue-600 bg-blue-50 hover:bg-blue-100">Login</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 font-medium rounded-lg transition text-white bg-blue-600 hover:bg-blue-700">Register</a>
                    @endguest
                </div>

                <div class="md:hidden" x-data="{ openUser: false }">
                    @auth
                        <button
                            type="button"
                            class="w-full text-left px-3 py-2 text-slate-700 font-semibold bg-slate-100 rounded-lg flex items-center justify-between"
                            @click="openUser = !openUser"
                        >
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>
                        <div x-show="openUser" x-cloak class="mt-2 border border-slate-200 rounded-lg bg-white">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-3 py-2 text-slate-700 font-medium hover:bg-red-50 hover:text-red-600 transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <path d="M16 17l5-5-5-5"></path>
                                        <path d="M21 12H9"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    @endauth
                    @guest
                        <a href="{{ route('login') }}" class="px-3 py-2 font-medium rounded-lg transition text-blue-600 bg-blue-50 hover:bg-blue-100 inline-block">Login</a>
                        <a href="{{ route('register') }}" class="px-3 py-2 font-medium rounded-lg transition text-white bg-blue-600 hover:bg-blue-700 inline-block mt-2">Register</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <div>
        @yield('content')
    </div>
</body>
</html>
