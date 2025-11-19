@extends('layouts.app')

@section('title', 'Create Ticket - Campus Helpdesk')

@section('content')
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a
            href="{{ route('student.dashboard') }}"
            class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold mb-6 transition"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M19 12H5"></path>
                <path d="M12 5l-7 7 7 7"></path>
            </svg>
            Back to Dashboard
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <h1 class="text-3xl font-bold text-slate-900 mb-2">Create New Ticket</h1>
            <p class="text-slate-600 mb-8">Submit a request for campus facility assistance</p>

            @php
                $categories = ['HVAC', 'Plumbing', 'Electrical', 'Security', 'Maintenance', 'Other'];
                $priorities = ['Low', 'Medium', 'High', 'Urgent'];
            @endphp

            <form action="{{ route('student.tickets.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        required
                        placeholder="Brief description of the issue"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="category"
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            @foreach ($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">
                            Priority <span class="text-red-500">*</span>
                        </label>
                        <select
                            name="priority"
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        >
                            @foreach ($priorities as $priority)
                                <option value="{{ $priority }}">{{ $priority }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="location"
                        required
                        placeholder="Building and room number (e.g., Building A - Room 101)"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">
                        Description
                    </label>
                    <textarea
                        name="description"
                        rows="6"
                        placeholder="Provide detailed information about the issue..."
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">
                        Attachment (optional)
                    </label>
                    <input
                        type="file"
                        name="attachment"
                        class="w-full border border-slate-300 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                <div class="flex gap-3 pt-6 border-t border-slate-200">
                    <button
                        type="submit"
                        class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-2 px-8 rounded-lg transition shadow-md hover:shadow-lg"
                    >
                        Submit Ticket
                    </button>
                    <a
                        href="{{ route('student.dashboard') }}"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-900 font-semibold py-2 px-8 rounded-lg transition inline-flex items-center justify-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
@endsection
