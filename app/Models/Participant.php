<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'participants';
    protected $primaryKey = 'participant_id';
    public $timestamps = true;

    protected $fillable = [
        'event_id',
        'full_name',
        'course',
        'year_level',
        'email',
        'contact_number',
    ];

    /**
     * Get the event this participant belongs to
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    /**
     * Scope to search by name
     */
    public function scopeSearchName($query, $name)
    {
        return $query->where('full_name', 'like', '%' . $name . '%');
    }

    /**
     * Scope to filter by course
     */
    public function scopeFilterCourse($query, $course)
    {
        return $query->where('course', $course);
    }

    /**
     * Scope to filter by year level
     */
    public function scopeFilterYearLevel($query, $yearLevel)
    {
        return $query->where('year_level', $yearLevel);
    }
}
