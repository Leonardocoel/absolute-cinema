<?php

namespace App\Models;

use App\Models\Session;
use App\Models\Schedule;
use App\Models\Reservation;
use App\Models\SessionMovie;
use App\Models\SessionSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Movie extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'synopsis',
        'duration_minutes',
        'release_date',
        'genre',
        'language',
        'rating',
        'availability',
        'image_url'
    ];

    protected $casts = [
        'release_date' => 'date:d/m/Y',
    ];

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'session_movies')->using(SessionMovie::class)->withTimestamps();
    }

    public function scheduleSessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'session_schedule')->using(SessionSchedule::class)->withTimestamps()->withPivot('schedule_id');
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'session_schedule')->using(SessionSchedule::class)->withTimestamps()->withPivot('movie_id');
    }

    public function reservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, SessionSchedule::class, 'movie_id', 'session_schedule_id');
    }
}
