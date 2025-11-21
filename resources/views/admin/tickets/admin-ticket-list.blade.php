@extends('layouts.app')

@section('title','Admin - Tickets')
@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Semua Pengajuan</h1>
    <table class="w-full bg-white">
        <thead>...</thead>
        <tbody>
            @forelse($tickets as $t)
                <tr>
                    <td>{{ $t->id }}</td>
                    <td><a href="{{ route('admin.tickets.show', $t) }}">{{ $t->title }}</a></td>
                    <td>{{ $t->user?->name ?? 'Guest' }}</td>
                    <td>{{ $t->priority }}</td>
                    <td>{{ $t->status }}</td>
                </tr>
            @empty
                <tr><td colspan="6">Tidak ada pengajuan</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $tickets->links() }}
</div>
@endsection