<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Schedule;
use App\Models\Reservation;
use App\Models\SessionMovie;
use App\Models\SessionSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Session extends Model
{
    use HasFactory;


    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'session_movies')->using(SessionMovie::class)->withTimestamps();
    }

    public function moviesWithSchedules(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'session_schedule')->using(SessionSchedule::class)->withTimestamps()->withPivot('schedule_id');
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'session_schedule')->using(SessionSchedule::class)->withTimestamps()->withPivot('movie_id');
    }

    public function reservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, SessionSchedule::class, 'session_id', 'session_schedule_id');
    }
}
