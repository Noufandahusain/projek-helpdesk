
@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('content')
<div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-2">{{ $ticket->title }}</h1>
    <p class="text-sm text-slate-600 mb-4">Diajukan oleh: {{ optional($ticket->user)->name ?? 'Guest' }} — {{ optional($ticket->user)->email ?? '-' }}</p>

    <div class="bg-white border rounded-lg p-4 mb-4">
        <p><strong>Lokasi:</strong> {{ $ticket->location }}</p>
        <p><strong>Kategori:</strong> {{ $ticket->category }}</p>
        <p><strong>Prioritas:</strong> {{ $ticket->priority }}</p>
        <p class="mt-2"><strong>Deskripsi:</strong></p>
        <p class="whitespace-pre-wrap">{{ $ticket->description }}</p>
    </div>

    <div class="bg-white border rounded-lg p-4 mb-4 flex items-center justify-between">
        <div>
            <p><strong>Status saat ini:</strong> <span class="font-semibold">{{ $ticket->status }}</span></p>
        </div>

        <form action="{{ route('admin.tickets.status.update', $ticket) }}" method="POST" class="flex items-center gap-2">
            @csrf
            @method('PATCH')
            <select name="status" class="border rounded px-3 py-2">
                <option value="Open" @selected($ticket->status === 'Open')>Open</option>
                <option value="In Progress" @selected($ticket->status === 'In Progress')>In Progress</option>
                <option value="Resolved" @selected($ticket->status === 'Resolved')>Resolved</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="text-sm text-slate-600">&larr; Kembali ke daftar</a>
</div>
@endsection