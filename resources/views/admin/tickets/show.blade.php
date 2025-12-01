
@extends('layouts.app')

@section('title','Detail Tiket - Admin')

@section('content')
<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-slate-900 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-slate-900">{{ $ticket->title }}</h1>
            <p class="text-slate-600 mt-1">
                Dilaporkan oleh {{ $creatorName }} &middot; {{ $ticket->category }} &middot; {{ $ticket->location }}
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center px-5 py-2.5 rounded-full text-base font-bold shadow-sm
                @class([
                    'bg-yellow-500 text-yellow-900' => $ticket->status === 'Open',
                    'bg-blue-500 text-white' => $ticket->status === 'In Progress',
                    'bg-green-500 text-white' => $ticket->status === 'Resolved',
                    'bg-slate-200 text-slate-800' => !in_array($ticket->status, ['Open','In Progress','Resolved']),
                ])
            ">
                {{ $ticket->status }}
            </span>
            <span class="inline-flex items-center justify-center px-5 py-2.5 rounded-full text-base font-bold shadow-sm
                @class([
                    'text-slate-700 border-2 border-slate-300 bg-transparent' => $ticket->priority === 'Low',
                    'bg-yellow-300 text-yellow-900' => $ticket->priority === 'Medium',
                    'bg-orange-500 text-white' => $ticket->priority === 'High',
                    'bg-red-600 text-white' => $ticket->priority === 'Urgent',
                ])
            ">
                {{ $ticket->priority }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-xl font-semibold text-slate-900 mb-4">Detail Pengaduan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-sm text-slate-600">
                    <p><span class="font-semibold text-slate-900">Ticket ID:</span> #{{ $ticket->id }}</p>
                    <p><span class="font-semibold text-slate-900">Lokasi:</span> {{ $ticket->location }}</p>
                    <p><span class="font-semibold text-slate-900">Kategori:</span> {{ $ticket->category }}</p>
                    <p><span class="font-semibold text-slate-900">Dibuat pada:</span> {{ $ticket->created_at }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-5">
                    <p class="text-sm font-semibold text-slate-600 uppercase mb-2">Deskripsi</p>
                    <p class="text-slate-800 leading-relaxed">{{ $ticket->description }}</p>
                </div>

                @if ($attachmentUrl)
                    @php
                        $extension = strtolower(pathinfo($ticket->attachment_path, PATHINFO_EXTENSION));
                        $isImage = in_array($extension, ['jpg','jpeg','png','gif','webp','bmp']);
                    @endphp
                    <div class="mt-6">
                        <p class="text-sm font-semibold text-slate-600 uppercase mb-2">Lampiran</p>
                        <div class="border border-slate-200 rounded-xl p-4 bg-white">
                            @if ($isImage)
                                <img src="{{ $attachmentUrl }}" class="rounded-xl max-h-96 object-contain mx-auto" alt="Lampiran tiket">
                            @else
                                <a href="{{ $attachmentUrl }}" target="_blank" class="inline-flex items-center gap-2 text-indigo-600 font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                        <path d="M12 5v14"></path>
                                        <path d="M5 12h14"></path>
                                    </svg>
                                    Unduh lampiran
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </section>

            <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-slate-900">Komentar & Balasan</h2>
                    <p class="text-sm text-slate-500">{{ $comments->count() }} komentar</p>
                </div>
                <div class="space-y-4 mb-6">
                    @forelse ($comments as $comment)
                        <div class="border border-slate-100 rounded-xl p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-slate-900">{{ $comment->author_name }}</p>
                                    <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-700 uppercase">{{ $comment->author_role }}</span>
                                </div>
                                <p class="text-xs text-slate-500">{{ $comment->created_at?->format('d M Y H:i') }}</p>
                            </div>
                            <p class="text-slate-700">{{ $comment->message }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-600">Belum ada komentar pada tiket ini.</p>
                    @endforelse
                </div>
                <form action="{{ route('admin.tickets.comments.store', $ticket) }}" method="POST" class="space-y-3">
                    @csrf
                    <label for="message" class="text-sm font-semibold text-slate-700">Tambahkan balasan</label>
                    <textarea
                        id="message"
                        name="message"
                        rows="4"
                        class="w-full border border-slate-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Tuliskan update atau pertanyaan untuk pelapor..."
                    ></textarea>
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition">
                        Kirim Balasan
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path d="M22 2 11 13"></path>
                            <path d="M22 2 15 22l-4-9-9-4Z"></path>
                        </svg>
                    </button>
                </form>
            </section>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Kontrol Status</h2>
                <form action="{{ route('admin.tickets.status', $ticket) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="status" class="text-sm font-semibold text-slate-700">Status tiket</label>
                        <select
                            id="status"
                            name="status"
                            class="w-full mt-1 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                            <option value="Open" @selected($ticket->status === 'Open')>Open</option>
                            <option value="In Progress" @selected($ticket->status === 'In Progress')>In Progress</option>
                            <option value="Resolved" @selected($ticket->status === 'Resolved')>Resolved</option>
                        </select>
                    </div>
                    <div>
                        <label for="note" class="text-sm font-semibold text-slate-700">Catatan (opsional)</label>
                        <textarea
                            id="note"
                            name="note"
                            rows="3"
                            class="w-full mt-1 border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            placeholder="Catatan ini akan muncul sebagai komentar kepada pelapor."
                        ></textarea>
                    </div>
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition">
                        Perbarui Status
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                            <path d="M21 2 9 14"></path>
                            <path d="M15 2h6v6"></path>
                            <path d="M3 22v-4a4 4 0 0 1 4-4h4"></path>
                        </svg>
                    </button>
                </form>
            </section>

            <section class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900 mb-4">Penanggung Jawab</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm font-semibold text-slate-700 mb-2">Admin Penanggung Jawab</p>
                        <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="p-2 bg-indigo-100 rounded-full">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                    <path d="M16 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0zM12 14a7 7 0 0 0-7 7h14a7 7 0 0 0-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900">{{ $ticket->assignedAdmin->name ?? 'Belum ditetapkan' }}</p>
                                <p class="text-xs text-slate-500">Admin yang menangani tiket ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</main>
@endsection