<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';
    protected $primaryKey = 'event_id';
    public $timestamps = true;

    protected $fillable = [
        'admin_id',
        'title',
        'description',
        'venue',
        'event_date',
        'status',
    ];

    protected $casts = [
        'event_date' => 'datetime',
    ];

    /**
     * Get the admin that created this event
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'admin_id');
    }

    /**
     * Get all participants for this event
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class, 'event_id', 'event_id');
    }

    /**
     * Get the calculated status based on event_date
     */
    public function getCalculatedStatusAttribute(): string
    {
        // $this->event_date is automatically a Carbon instance thanks to $casts
        if ($this->event_date->isFuture()) {
            return 'upcoming';
        } elseif ($this->event_date->isToday()) {
            return 'ongoing';
        } else {
            return 'done';
        }
    }

    /**
     * Check if event is upcoming
     */
    public function isUpcoming(): bool
    {
        return $this->event_date->isFuture();
    }

    /**
     * Check if event is ongoing
     */
    public function isOngoing(): bool
    {
        return $this->event_date->isToday();
    }

    /**
     * Check if event is done
     */
    public function isDone(): bool
    {
        // Event is done if date is past OR if date is today but time has passed
        return $this->event_date->isPast() || 
               ($this->event_date->isToday() && now()->greaterThan($this->event_date));
    }

    /**
     * Get formatted event date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->event_date->format('M d, Y H:i');
    }

    /**
     * Scope to get upcoming events (Strictly after today)
     */
    public function scopeUpcoming($query)
    {
        return $query->where('event_date', '>', Carbon::now()->endOfDay());
    }

    /**
     * Scope to get ongoing events (Any time windows falling on today's date)
     */
    public function scopeOngoing($query)
    {
        return $query->whereDate('event_date', Carbon::today());
    }

    /**
     * Scope to get completed events (Strictly before today started)
     */
    public function scopeCompleted($query)
    {
        // FIX: An event is only "completed" in the dashboard metrics if its date is fully before today
        return $query->where('event_date', '<', Carbon::today());
    }

    /**
     * Scope to search by title
     */
    public function scopeSearchTitle($query, $title)
    {
        return $query->where('title', 'like', '%' . $title . '%');
    }

    /**
     * Scope to filter by status
     */
    public function scopeFilterStatus($query, $status)
    {
        if ($status === 'upcoming') {
            return $query->upcoming();
        } elseif ($status === 'ongoing') {
            return $query->ongoing();
        } elseif ($status === 'done') {
            return $query->completed();
        }
        return $query;
    }
}