<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;
use App\Notifications\TicketStatusUpdated;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TicketController extends Controller
{
    /* ============================================================
    |  STUDENT DASHBOARD
    ============================================================ */
    public function dashboard(): View
    {
        $user = Auth::user();
        $tickets = Ticket::where('user_id', $user->id)->latest()->get();
        $notifications = $user->notifications()->latest()->limit(5)->get();
        $unreadCollection = $user->unreadNotifications;
        $unreadNotifications = $unreadCollection->count();

        if ($unreadCollection->isNotEmpty()) {
            $unreadCollection->markAsRead();
        }

        return view('student.dashboard', [
            'tickets' => $tickets,
            'totalTickets' => $tickets->count(),
            'openTickets' => $tickets->where('status', 'Open')->count(),
            'inProgressTickets' => $tickets->where('status', 'In Progress')->count(),
            'resolvedTickets' => $tickets->where('status', 'Resolved')->count(),
            'notifications' => $notifications,
            'unreadNotifications' => $unreadNotifications,
        ]);
    }

    /* ============================================================
    |  STUDENT - MY TICKETS
    ============================================================ */
    public function index(): View
    {
        $tickets = Ticket::where('user_id', Auth::id())->latest()->get();

        return view('student.my-tickets', ['tickets' => $tickets]);
    }

    /* ============================================================
    |  STUDENT CREATE TICKET
    ============================================================ */
    public function create(): View
    {
        return view('student.create-ticket');
    }

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

        $attachmentPath = $request->hasFile('attachment')
            ? $request->file('attachment')->store('ticket-attachments', 'public')
            : null;

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

    /* ============================================================
    |  STUDENT / ADMIN - SHOW TICKET
    ============================================================ */
    public function show(Ticket $ticket): View
    {
        $this->authorizeTicketVisibility($ticket);

        $ticket->load([
            'comments' => fn($q) => $q->latest(),
            'user',
            'assignedAdmin',
        ]);

        $attachmentUrl = $ticket->attachment_path ? Storage::url($ticket->attachment_path) : null;

        if (Auth::user()->role === 'admin') {
            return view('admin.tickets.show', [
                'ticket' => $ticket,
                'comments' => $ticket->comments,
                'attachmentUrl' => $attachmentUrl,
                'creatorName' => $ticket->user?->name ?? 'Unknown',
                'admins' => User::where('role', 'admin')->orderBy('name')->get(),
            ]);
        }

        return view('student.ticket-detail', [
            'ticket' => $ticket,
            'comments' => $ticket->comments,
            'attachmentUrl' => $attachmentUrl,
            'creatorName' => $ticket->user?->name ?? 'Unknown',
        ]);
    }

    /* ============================================================
    |  STUDENT COMMENT
    ============================================================ */
    public function addComment(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorizeTicketVisibility($ticket);

        $validated = $request->validate([
            'message' => ['required', 'string'],
        ]);

        TicketComment::create([
            'ticket_id' => $ticket->id,
            'author_name' => Auth::user()->name,
            'author_role' => Auth::user()->role,
            'message' => $validated['message'],
        ]);

        return redirect()->back()->with('status', 'Comment added.');
    }

    /* ============================================================
    |  STUDENT EDIT TICKET
    ============================================================ */
    public function edit(Ticket $ticket): View
    {
        return view('student.edit-ticket', ['ticket' => $ticket]);
    }

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

        if ($request->hasFile('attachment')) {
            if ($ticket->attachment_path) {
                Storage::disk('public')->delete($ticket->attachment_path);
            }
            $ticket->attachment_path = $request->file('attachment')->store('ticket-attachments', 'public');
        }

        $ticket->update($validated);

        return redirect()
            ->route('student.tickets.show', $ticket)
            ->with('status', 'Ticket updated successfully.');
    }

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

    /* ============================================================
    |  STUDENT PDF REPORT
    ============================================================ */
    public function downloadReport(Ticket $ticket)
    {
        $ticket->load(['user', 'comments' => fn($q) => $q->latest()]);

        $pdf = Pdf::loadView('student.ticket-report', [
            'ticket' => $ticket,
            'comments' => $ticket->comments,
            'creatorName' => $ticket->user?->name ?? 'Unknown',
        ])->setPaper('a4');

        return $pdf->download("ticket-{$ticket->id}.pdf");
    }

    /* ============================================================
    |  ADMIN — DASHBOARD
    ============================================================ */
    public function adminDashboard(): View
    {
        $tickets = Ticket::with(['user', 'assignedAdmin'])->latest()->get();

        return view('admin.dashboard', [
            'tickets' => $tickets,
            'totalTickets' => $tickets->count(),
            'openTickets' => $tickets->where('status', 'Open')->count(),
            'inProgressTickets' => $tickets->where('status', 'In Progress')->count(),
            'resolvedTickets' => $tickets->where('status', 'Resolved')->count(),
            'unassignedTickets' => $tickets->whereNull('assigned_admin_id')->count(),
            'recentTickets' => $tickets->take(5),
            'highPriorityOpen' => $tickets->filter(function ($ticket) {
                return $ticket->status !== 'Resolved' && in_array($ticket->priority, ['High', 'Urgent']);
            })->count(),
        ]);
    }

    /* ============================================================
    |  ADMIN — LIST ALL TICKETS
    ============================================================ */
    public function adminIndex(Request $request): View
    {
        $query = Ticket::with(['user', 'assignedAdmin'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $term = $request->get('search');
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('category', 'like', "%{$term}%")
                    ->orWhere('location', 'like', "%{$term}%");
            });
        }

        $tickets = $query->paginate(10)->withQueryString();

        return view('admin.tickets.index', [
            'tickets' => $tickets,
            'filters' => $request->only(['status', 'priority', 'search']),
        ]);
    }

    /* ============================================================
    |  ADMIN — UPDATE STATUS
    ============================================================ */
    public function updateStatus(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Open', 'In Progress', 'Resolved'])],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $ticket->update([
            'status' => $validated['status'],
        ]);

        if (!empty($validated['note'])) {
            TicketComment::create([
                'ticket_id' => $ticket->id,
                'author_name' => Auth::user()->name,
                'author_role' => Auth::user()->role,
                'message' => $validated['note'],
            ]);
        }

        if ($ticket->user) {
            $ticket->user->notify(new TicketStatusUpdated($ticket, Auth::user()));
        }

        return redirect()
            ->back()
            ->with('status', 'Ticket status updated.');
    }

    public function assignAdmin(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validate([
            'assigned_admin_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn($q) => $q->where('role', 'admin')),
            ],
        ]);

        $ticket->update([
            'assigned_admin_id' => $validated['assigned_admin_id'] ?? null,
        ]);

        return back()->with('status', 'Ticket assignment updated.');
    }

    protected function authorizeTicketVisibility(Ticket $ticket): void
    {
        if (Auth::user()->role === 'admin') {
            return;
        }

        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
