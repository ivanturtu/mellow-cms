<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'new' => 'badge bg-primary',
            'read' => 'badge bg-info',
            'replied' => 'badge bg-success',
            'archived' => 'badge bg-secondary',
            default => 'badge bg-secondary'
        };
    }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'new' => 'Nuovo',
            'read' => 'Letto',
            'replied' => 'Risposto',
            'archived' => 'Archiviato',
            default => 'Sconosciuto'
        };
    }
}