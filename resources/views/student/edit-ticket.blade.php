@extends('layouts.app')

@section('title', 'Edit Ticket - Campus Helpdesk')

@section('content')
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <a
            href="{{ route('student.tickets.show', $ticket) }}"
            class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold mb-6 transition"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M19 12H5"></path>
                <path d="M12 5l-7 7 7 7"></path>
            </svg>
            Back to Ticket
        </a>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Edit Ticket</h1>
                    <p class="text-slate-600 mt-2">Perbarui informasi tiket Anda</p>
                </div>
                <span class="text-sm font-semibold text-slate-500">ID: {{ $ticket->id }}</span>
            </div>

            <form action="{{ route('student.tickets.update', $ticket) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $ticket->title) }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    @error('title')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-900 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $ticket->category) }}"
                            required
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        />
                        @error('category')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
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
                            @foreach (['Low', 'Medium', 'High', 'Urgent'] as $priority)
                                <option value="{{ $priority }}" @selected(old('priority', $ticket->priority) === $priority)>{{ $priority }}</option>
                            @endforeach
                        </select>
                        @error('priority')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        name="location"
                        value="{{ old('location', $ticket->location) }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    @error('location')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-900 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        name="description"
                        rows="6"
                        required
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >{{ old('description', $ticket->description) }}</textarea>
                    @error('description')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
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
                    @if ($ticket->attachment_path)
                        <p class="text-sm text-slate-600 mt-2">
                            Attachment saat ini:
                            <a href="{{ Storage::url($ticket->attachment_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700 font-semibold">
                                Lihat file
                            </a>
                        </p>
                    @endif
                    @error('attachment')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-6 border-t border-slate-200">
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-8 rounded-lg transition shadow-md hover:shadow-lg"
                    >
                        Update Ticket
                    </button>
                    <a
                        href="{{ route('student.tickets.show', $ticket) }}"
                        class="bg-slate-200 hover:bg-slate-300 text-slate-900 font-semibold py-2 px-8 rounded-lg transition inline-flex items-center justify-center"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>
@endsection
