<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #0f172a; font-size: 12px; margin: 0; padding: 24px; }
        h1 { font-size: 20px; margin-bottom: 4px; }
        h2 { font-size: 16px; margin-top: 24px; margin-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #cbd5f5; padding: 8px; text-align: left; vertical-align: top; }
        .label { font-weight: bold; width: 140px; }
        .section { margin-top: 20px; }
        .comment { border: 1px solid #e2e8f0; padding: 10px; border-radius: 6px; margin-bottom: 10px; }
        .comment-header { display: flex; justify-content: space-between; font-size: 11px; color: #64748b; }
    </style>
</head>
<body>
    <div>
        <h1>Ticket Report - {{ $ticket->title }}</h1>
        <p>ID: {{ $ticket->id }}</p>
    </div>

    <div class="section">
        <h2>Ticket Details</h2>
        <table>
            <tr>
                <th class="label">Status</th>
                <td>{{ $ticket->status }}</td>
            </tr>
            <tr>
                <th class="label">Priority</th>
                <td>{{ $ticket->priority }}</td>
            </tr>
            <tr>
                <th class="label">Category</th>
                <td>{{ $ticket->category }}</td>
            </tr>
            <tr>
                <th class="label">Location</th>
                <td>{{ $ticket->location }}</td>
            </tr>
            <tr>
                <th class="label">Created By</th>
                <td>{{ $creatorName }}</td>
            </tr>
            <tr>
                <th class="label">Created At</th>
                <td>{{ $ticket->created_at }}</td>
            </tr>
            <tr>
                <th class="label">Last Updated</th>
                <td>{{ $ticket->updated_at }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Description</h2>
        <p>{{ $ticket->description }}</p>
    </div>

    <div class="section">
        <h2>Comments</h2>
        @forelse ($comments as $comment)
            <div class="comment">
                <div class="comment-header">
                    <span>{{ $comment->author_name }} ({{ $comment->author_role }})</span>
                    <span>{{ $comment->created_at?->format('Y-m-d H:i') }}</span>
                </div>
                <p>{{ $comment->message }}</p>
            </div>
        @empty
            <p>No comments available.</p>
        @endforelse
    </div>
</body>
</html>
