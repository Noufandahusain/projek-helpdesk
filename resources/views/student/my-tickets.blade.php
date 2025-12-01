@extends('layouts.app')

@section('title', 'My Tickets - Campus Helpdesk')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900">My Tickets</h1>
            <p class="text-slate-600 mt-2">View and manage all your submitted tickets</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 4h16l-5 7v5l-6 4v-9z"></path>
                </svg>
                <h2 class="text-lg font-semibold text-slate-900">Filters</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Statuses</option>
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Resolved">Resolved</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Priority</label>
                    <select class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all">All Priorities</option>
                        <option value="Low">Low</option>
                        <option value="Medium">Medium</option>
                        <option value="High">High</option>
                        <option value="Urgent">Urgent</option>
                    </select>
                </div>
            </div>
        </div>

        @php
            $statusClasses = [
                'Open' => 'bg-yellow-100 text-yellow-800',
                'In Progress' => 'bg-blue-100 text-blue-800',
                'Resolved' => 'bg-green-100 text-green-800',
            ];
            $priorityClasses = [
                'Low' => 'text-slate-600',
                'Medium' => 'text-yellow-600',
                'High' => 'text-orange-600',
                'Urgent' => 'text-red-600',
            ];
        @endphp

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-xl font-bold text-slate-900">All Tickets ({{ isset($tickets) ? count($tickets) : 0 }})</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Ticket ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Assigned Admin</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Priority</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-600 uppercase tracking-wider">Updated</th>
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
                                    <span class="text-slate-700 font-medium">{{ $ticket->title }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-700">{{ $ticket->category }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusClasses[$ticket->status] ?? 'bg-slate-100 text-slate-800' }}">
                                        {{ $ticket->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-700 text-sm">{{ $ticket->assignedAdmin->name ?? 'Belum ditetapkan' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold {{ $priorityClasses[$ticket->priority] ?? 'text-slate-600' }}">
                                        {{ $ticket->priority }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-slate-600 text-sm">{{ $ticket->updated_at ?? $ticket->updatedAt ?? '' }}</span>
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
                                <td colspan="8" class="px-6 py-12 text-center text-slate-600 font-medium">
                                    No tickets found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
