@extends('layouts.app')

@section('title', 'Ticket Detail - Campus Helpdesk')

@section('content')
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <a
                href="{{ route('student.tickets.index') }}"
                class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold transition"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M19 12H5"></path>
                    <path d="M12 5l-7 7 7 7"></path>
                </svg>
                Back
            </a>

            <div class="flex items-center gap-3">
                <a
                    href="{{ route('student.tickets.edit', $ticket) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                    </svg>
                    Edit Ticket
                </a>
                <form action="{{ route('student.tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition shadow-sm"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 6h18"></path>
                            <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <path d="M19 6v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                            <path d="M10 11v6"></path>
                            <path d="M14 11v6"></path>
                        </svg>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        @php
            $statusClasses = [
                'Open' => 'bg-yellow-100 text-yellow-800',
                'In Progress' => 'bg-blue-100 text-blue-800',
                'Resolved' => 'bg-green-100 text-green-800',
            ];
            $priorityBadges = [
                'Low' => 'bg-slate-100 text-slate-800',
                'Medium' => 'bg-yellow-100 text-yellow-800',
                'High' => 'bg-orange-100 text-orange-800',
                'Urgent' => 'bg-red-100 text-red-800',
            ];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-slate-900">{{ $ticket->title }}</h1>
                            <p class="text-slate-600 mt-2">{{ $ticket->id }}</p>
                        </div>
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold w-fit {{ $statusClasses[$ticket->status] ?? 'bg-slate-100 text-slate-800' }}">
                            {{ $ticket->status }}
                        </span>
                    </div>

                    <div class="bg-slate-50 rounded-lg p-6 mb-6">
                        <h3 class="font-semibold text-slate-900 mb-4">Description</h3>
                        <p class="text-slate-700 leading-relaxed">{{ $ticket->description }}</p>

                        @if(!empty($attachmentUrl))
                            @php
                                $extension = strtolower(pathinfo($ticket->attachment_path, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                            @endphp
                            <div class="mt-6">
                                <p class="text-sm font-medium text-slate-600 mb-2">Attachment</p>
                                <div class="border border-slate-200 rounded-lg p-4 bg-white">
                                    @if($isImage)
                                        <img src="{{ $attachmentUrl }}" alt="Ticket Attachment" class="rounded-lg max-h-80 object-contain mx-auto">
                                    @else
                                        <a href="{{ $attachmentUrl }}" target="_blank" class="text-blue-600 hover:text-blue-700 font-semibold">
                                            Download attachment
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Category</p>
                            <p class="text-slate-900 font-semibold">{{ $ticket->category }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Location</p>
                            <p class="text-slate-900 font-semibold">{{ $ticket->location }}</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M21 15a2 2 0 0 1-2 2h-3l-4 4v-4H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Updates & Comments
                        </h3>

                        <div class="space-y-4 mb-6">
                            @forelse ($comments as $comment)
                                <div class="bg-slate-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold text-slate-900">{{ $comment->author_name }}</p>
                                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded font-medium">{{ $comment->author_role }}</span>
                                        </div>
                                        <p class="text-xs text-slate-500">{{ $comment->created_at?->format('Y-m-d H:i') }}</p>
                                    </div>
                                    <p class="text-slate-700">{{ $comment->message }}</p>
                                </div>
                            @empty
                                <p class="text-slate-600">No comments yet.</p>
                            @endforelse
                        </div>

                        <form action="{{ route('student.tickets.comments.store', $ticket) }}" method="POST" class="space-y-3">
                            @csrf
                            <textarea
                                name="message"
                                rows="4"
                                placeholder="Add a comment..."
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            ></textarea>
                            <button
                                type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition"
                            >
                                Add Comment
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 sticky top-24">
                    <h3 class="font-semibold text-slate-900 mb-4">Ticket Details</h3>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Priority</p>
                            <span class="inline-block px-3 py-1.5 rounded-lg text-sm font-semibold {{ $priorityBadges[$ticket->priority] ?? 'bg-slate-100 text-slate-800' }}">
                                {{ $ticket->priority }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Created By</p>
                            <p class="text-slate-900 font-medium">{{ $creatorName ?? 'Unknown' }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Created At</p>
                            <p class="text-slate-900 font-medium">{{ $ticket->created_at }}</p>
                        </div>

                        <div>
                            <p class="text-sm font-medium text-slate-600 mb-1">Last Updated</p>
                            <p class="text-slate-900 font-medium">{{ $ticket->updated_at ?? $ticket->updatedAt ?? '' }}</p>
                        </div>

                        <div class="border-t border-slate-200 pt-4">
                            <a
                                href="{{ route('student.tickets.report', $ticket) }}"
                                class="w-full inline-block text-center bg-slate-100 hover:bg-slate-200 text-slate-900 font-semibold py-2 px-4 rounded-lg transition"
                            >
                                Download Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
