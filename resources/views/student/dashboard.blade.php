@extends('layouts.app')

@section('title', 'Student Dashboard - Campus Helpdesk')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div>
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">Student Dashboard</h1>
                <p class="text-slate-600 mt-2">Welcome back! Monitor your facility requests</p>
            </div>
            <a
                href="{{ route('student.tickets.create') }}"
                class="mt-4 sm:mt-0 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2 px-6 rounded-lg flex items-center gap-2 transition shadow-md hover:shadow-lg"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 5v14"></path>
                    <path d="M5 12h14"></path>
                </svg>
                Create Ticket
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Total Tickets</p>
                        <p class="text-4xl font-bold text-slate-900 mt-3">{{ $totalTickets ?? 0 }}</p>
                    </div>
                    <div class="p-4 bg-blue-100 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 7l5-4h8l5 4v10l-5 4H8l-5-4z"></path>
                            <path d="M3 7l9 6 9-6"></path>
                            <path d="M3 17l5-4"></path>
                            <path d="M21 17l-5-4"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4">All time requests</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Open</p>
                        <p class="text-4xl font-bold text-yellow-600 mt-3">{{ $openTickets ?? 0 }}</p>
                    </div>
                    <div class="p-4 bg-yellow-100 rounded-xl">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 7v5"></path>
                            <path d="M12 16h.01"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4">Waiting for review</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600">In Progress</p>
                        <p class="text-4xl font-bold text-blue-600 mt-3">{{ $inProgressTickets ?? 0 }}</p>
                    </div>
                    <div class="p-4 bg-blue-100 rounded-xl">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 7v5l3 3"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4">Being worked on</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600">Resolved</p>
                        <p class="text-4xl font-bold text-green-600 mt-3">{{ $resolvedTickets ?? 0 }}</p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-xl">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 6L9 17l-5-5"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-xs text-slate-500 mt-4">Completed requests</p>
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
                <h2 class="text-xl font-bold text-slate-900">Recent Tickets</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Ticket ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Location</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        @forelse ($tickets as $ticket)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">
                                    <span class="font-semibold text-slate-900">{{ $ticket->id }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-700">{{ $ticket->category }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-700">{{ $ticket->location }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClasses[$ticket->status] ?? 'bg-slate-100 text-slate-800' }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-600 text-sm">{{ $ticket->created_at }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a
                                        href="{{ route('student.tickets.show', $ticket->id) }}"
                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-700 font-semibold hover:bg-blue-50 px-3 py-1.5 rounded-lg transition"
                                    >
                                        View
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M9 18l6-6-6-6"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-600 font-medium">
                                    No tickets available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
