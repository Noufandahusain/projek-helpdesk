<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category',
        'priority',
        'location',
        'description',
        'attachment_path',
        'status',
        'assigned_admin_id',
    ];

    protected $attributes = [
        'status' => 'Open',
    ];

    public function comments()
    {
        return $this->hasMany(\App\Models\TicketComment::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }
}
