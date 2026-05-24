<?php

namespace App\Models;

use App\Models\Participant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
// REMOVED: use Illuminate\Contracts\Auth\Authenticatable;
// REMOVED: use Illuminate\Database\Eloquent\Model;

// ADDED: This pulls in the fully implemented User base class
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';
    protected $primaryKey = 'admin_id';
    public $timestamps = true;

    protected $fillable = [
        'username',
        'email',
        'password',
        'full_name',
    ];

    protected $hidden = [
        'password',
        'remember_token', // Good habit to hide this if you use "remember me" features
    ];

    /**
     * Get all events created by this admin
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'admin_id', 'admin_id');
    }

    /**
     * Get total number of events created by this admin
     */
    public function getTotalEventsAttribute(): int
    {
        return $this->events()->count();
    }

    /**
     * Get total number of participants across all admin's events
     */
    public function getTotalParticipantsAttribute(): int
    {
        // Optimized query to avoid N+1 problem
        return Participant::whereIn(
            'event_id', 
            $this->events()->select('event_id')
        )->count();
    }
}