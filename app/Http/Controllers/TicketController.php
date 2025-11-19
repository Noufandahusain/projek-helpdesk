<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Display dashboard metrics and sample tickets.
     */
    public function dashboard(): View
    {
        $tickets = Ticket::latest()->get();

        return view('student.dashboard', [
            'tickets' => $tickets,
            'totalTickets' => $tickets->count(),
            'openTickets' => $tickets->where('status', 'Open')->count(),
            'inProgressTickets' => $tickets->where('status', 'In Progress')->count(),
            'resolvedTickets' => $tickets->where('status', 'Resolved')->count(),
        ]);
    }

    /**
     * Show paginated / full list of tickets.
     */
    public function index(): View
    {
        $tickets = Ticket::latest()->get();

        return view('student.my-tickets', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * Show ticket creation form.
     */
    public function create(): View
    {
        return view('student.create-ticket');
    }

    /**
     * Store a newly created ticket in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('ticket-attachments', 'public');
        }

        Ticket::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()
            ->route('student.tickets.index')
            ->with('status', 'Ticket created successfully.');
    }

    /**
     * Display the specified ticket.
     */
    public function show(Ticket $ticket): View
    {
        // Comments feature not yet implemented; send empty collection for now.
        $ticket->load(['comments' => fn ($query) => $query->latest(), 'user']);
        $attachmentUrl = $ticket->attachment_path ? Storage::url($ticket->attachment_path) : null;
        $creatorName = $ticket->user?->name ?? 'Unknown';

        return view('student.ticket-detail', [
            'ticket' => $ticket,
            'comments' => $ticket->comments,
            'attachmentUrl' => $attachmentUrl,
            'creatorName' => $creatorName,
        ]);
    }

    /**
     * Store a comment for the given ticket.
     */
    public function addComment(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string'],
            'author_name' => ['nullable', 'string', 'max:255'],
        ]);

        TicketComment::create([
            'ticket_id' => $ticket->id,
            'author_name' => $validated['author_name'] ?? 'You',
            'author_role' => 'Requester',
            'message' => $validated['message'],
        ]);

        return redirect()
            ->route('student.tickets.show', $ticket)
            ->with('status', 'Comment added.');
    }

    /**
     * Show the form for editing the specified ticket.
     */
    public function edit(Ticket $ticket): View
    {
        return view('student.edit-ticket', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Update the specified ticket in storage.
     */
    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'priority' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $attachmentPath = $ticket->attachment_path;
        if ($request->hasFile('attachment')) {
            if ($attachmentPath) {
                Storage::disk('public')->delete($attachmentPath);
            }

            $attachmentPath = $request->file('attachment')->store('ticket-attachments', 'public');
        }

        $ticket->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'priority' => $validated['priority'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'attachment_path' => $attachmentPath,
        ]);

        return redirect()
            ->route('student.tickets.show', $ticket)
            ->with('status', 'Ticket updated successfully.');
    }

    /**
     * Remove the specified ticket from storage.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        if ($ticket->attachment_path) {
            Storage::disk('public')->delete($ticket->attachment_path);
        }

        $ticket->comments()->delete();
        $ticket->delete();

        return redirect()
            ->route('student.tickets.index')
            ->with('status', 'Ticket deleted successfully.');
    }

    /**
     * Download a PDF report for the given ticket.
     */
    public function downloadReport(Ticket $ticket)
    {
        $ticket->load(['user', 'comments' => fn ($query) => $query->latest()]);

        $pdf = Pdf::loadView('student.ticket-report', [
            'ticket' => $ticket,
            'comments' => $ticket->comments,
            'creatorName' => $ticket->user?->name ?? 'Unknown',
        ])->setPaper('a4');

        return $pdf->download("ticket-{$ticket->id}.pdf");
    }
}
