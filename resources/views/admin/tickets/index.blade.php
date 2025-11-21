@extends('layouts.app')

@section('title', 'Kelola Tiket - Admin')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <p class="text-sm uppercase tracking-wide text-slate-500 font-semibold">Helpdesk Admin</p>
            <h1 class="text-3xl font-bold text-slate-900">Manajemen Tiket</h1>
            <p class="text-slate-600 mt-1">Kelola seluruh tiket, tetapkan admin, dan pantau progres.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700">
            Lihat Dashboard
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6"></path>
            </svg>
        </a>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 mb-8">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label for="status" class="text-sm font-semibold text-slate-700 mb-1 block">Status</label>
                <select
                    id="status"
                    name="status"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">Semua status</option>
                    <option value="Open" @selected(request('status') === 'Open')>Open</option>
                    <option value="In Progress" @selected(request('status') === 'In Progress')>In Progress</option>
                    <option value="Resolved" @selected(request('status') === 'Resolved')>Resolved</option>
                </select>
            </div>
            <div>
                <label for="priority" class="text-sm font-semibold text-slate-700 mb-1 block">Prioritas</label>
                <select
                    id="priority"
                    name="priority"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                    <option value="">Semua prioritas</option>
                    @foreach (['Low','Medium','High','Urgent'] as $priority)
                        <option value="{{ $priority }}" @selected(request('priority') === $priority)>{{ $priority }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label for="search" class="text-sm font-semibold text-slate-700 mb-1 block">Cari tiket</label>
                <div class="flex rounded-lg border border-slate-300 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-transparent overflow-hidden">
                    <input
                        type="text"
                        id="search"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari berdasarkan judul, lokasi, atau kategori..."
                        class="w-full px-3 py-2 text-sm outline-none"
                    >
                    <button type="submit" class="bg-indigo-600 text-white px-5 text-sm font-semibold">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Daftar Tiket</h2>
            <p class="text-sm text-slate-500">Menampilkan {{ $tickets->total() }} tiket</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Judul</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Pelapor</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Prioritas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Assigned</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Terakhir Update</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 text-sm font-semibold text-slate-900">#{{ $ticket->id }}</td>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-slate-900">{{ $ticket->title }}</p>
                                <p class="text-xs text-slate-500">{{ $ticket->category }} • {{ $ticket->location }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">{{ $ticket->user->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                    @class([
                                        'bg-slate-100 text-slate-800' => $ticket->priority === 'Low',
                                        'bg-yellow-100 text-yellow-800' => $ticket->priority === 'Medium',
                                        'bg-orange-100 text-orange-800' => $ticket->priority === 'High',
                                        'bg-red-100 text-red-800' => $ticket->priority === 'Urgent',
                                    ])
                                ">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            @php
                                $statusClasses = [
                                    'Open' => 'bg-yellow-100 text-yellow-800',
                                    'In Progress' => 'bg-blue-100 text-blue-800',
                                    'Resolved' => 'bg-green-100 text-green-800',
                                ];
                            @endphp
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$ticket->status] ?? 'bg-slate-100 text-slate-800' }}">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-700">
                                {{ $ticket->assignedAdmin->name ?? 'Belum ditetapkan' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $ticket->updated_at?->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <a
                                    href="{{ route('admin.tickets.show', $ticket) }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition"
                                >
                                    Detail
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path d="M9 18l6-6-6-6"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-slate-600 font-semibold">
                                Tidak ada tiket ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $tickets->links() }}
        </div>
    </div>
</main>
@endsection

