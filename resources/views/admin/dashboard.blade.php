@extends('layouts.app')

@section('title', 'Admin Dashboard - Campus Helpdesk')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Admin Dashboard</h1>
            <p class="text-slate-600 mt-2">Manage and monitor all student facility reports</p>
        </div>

        <!-- <div class="mt-4 sm:mt-0 bg-indigo-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M3 12h18"></path>
                <path d="M12 3v18"></path>
            </svg>
            Admin Panel
        </div> -->
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Tickets</p>
                    <p class="text-4xl font-bold text-slate-900 mt-3">{{ $totalTickets }}</p>
                </div>
                <div class="p-4 bg-indigo-100 rounded-xl">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                        <path d="M3 7l5-4h8l5 4v10l-5 4H8l-5-4z"></path>
                        <path d="M3 7l9 6 9-6"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4">All incoming reports</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Open</p>
                    <p class="text-4xl font-bold text-yellow-600 mt-3">{{ $openTickets }}</p>
                </div>
                <div class="p-4 bg-yellow-100 rounded-xl">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 7v5"></path>
                        <path d="M12 16h.01"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4">Awaiting admin response</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">In Progress</p>
                    <p class="text-4xl font-bold text-blue-600 mt-3">{{ $inProgressTickets }}</p>
                </div>
                <div class="p-4 bg-blue-100 rounded-xl">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9"></circle>
                        <path d="M12 7v5l3 3"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4">Currently being handled</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Resolved</p>
                    <p class="text-4xl font-bold text-green-600 mt-3">{{ $resolvedTickets }}</p>
                </div>
                <div class="p-4 bg-green-100 rounded-xl">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M20 6L9 17l-5-5"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-4">Completed tasks</p>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-orange-50 border border-orange-100 rounded-2xl p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-orange-700 uppercase tracking-wide">High priority open</p>
                <p class="text-4xl font-bold text-orange-900 mt-2">{{ $highPriorityOpen }}</p>
                <p class="text-sm text-orange-700 mt-1">Fokuskan pada prioritas tinggi & urgent.</p>
            </div>
            <div class="p-4 bg-white rounded-2xl shadow">
                <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M12 6v6l3 3"></path>
                    <circle cx="12" cy="12" r="9"></circle>
                </svg>
            </div>
        </div>
    </div>

    @php
        $statusClasses = [
            'Open' => 'bg-yellow-100 text-yellow-800',
            'In Progress' => 'bg-blue-100 text-blue-800',
            'Resolved' => 'bg-green-100 text-green-800',
        ];
    @endphp

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-xl font-bold text-slate-900">All Ticket Reports</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Category</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Priority</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Location</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Assigned</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Created</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse ($tickets as $ticket)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $ticket->id }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $ticket->user->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $ticket->category }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                    @class([
                                        'bg-slate-100 text-slate-800' => $ticket->priority === 'Low',
                                        'bg-yellow-100 text-yellow-800' => $ticket->priority === 'Medium',
                                        'bg-orange-100 text-orange-800' => $ticket->priority === 'High',
                                        'bg-red-100 text-red-800' => $ticket->priority === 'Urgent',
                                        'bg-slate-100 text-slate-800' => !in_array($ticket->priority, ['Low','Medium','High','Urgent']),
                                    ])
                                ">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-700">{{ $ticket->location }}</td>
                            <td class="px-6 py-4 text-slate-700">{{ $ticket->assignedAdmin->name ?? 'Belum ditetapkan' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClasses[$ticket->status] }}">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 text-sm">{{ $ticket->created_at }}</td>
                            <td class="px-6 py-4">
                                <a
                                    href="{{ route('admin.tickets.show', $ticket->id) }}"
                                    class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-700 font-semibold hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition"
                                >
                                    Review
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path d="M9 18l6-6-6-6"></path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-600 font-medium">
                                No tickets available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-900">Aktivitas Terbaru</h2>
                <a href="{{ route('admin.tickets.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700">Kelola tiket</a>
            </div>
            <div class="space-y-4">
                @forelse ($recentTickets as $recent)
                    <div class="flex items-start gap-3">
                        <div class="p-2 rounded-full bg-indigo-100 text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M21 15a2 2 0 0 1-2 2h-3l-4 4v-4H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-slate-900">{{ $recent->title }}</p>
                                <span class="text-xs text-slate-500">{{ $recent->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-slate-600">{{ $recent->user->name ?? 'Unknown' }} • {{ $recent->category }}</p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$recent->status] }}">{{ $recent->status }}</span>
                                <span class="text-xs text-slate-500">Assigned: {{ $recent->assignedAdmin->name ?? 'Belum ada' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-600">Belum ada tiket baru.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
            <h2 class="text-xl font-bold text-slate-900 mb-4">Catatan Operasional</h2>
            <ul class="space-y-4 text-sm text-slate-700">
                <li class="flex items-start gap-3">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 mt-2"></span>
                    Fokuskan penanganan pada tiket dengan status <strong>Open</strong> agar tidak menumpuk.
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-2 h-2 rounded-full bg-orange-500 mt-2"></span>
                    Pastikan setiap tiket prioritas tinggi memiliki admin penanggung jawab.
                </li>
                <li class="flex items-start gap-3">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mt-2"></span>
                    Dorong komunikasi aktif melalui fitur komentar untuk transparansi progres.
                </li>
            </ul>
        </div>
    </div>

</main>
@endsection
