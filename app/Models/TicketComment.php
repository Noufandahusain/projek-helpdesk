<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'author_name',
        'author_role',
        'message',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
