<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\Schedule;
use App\Models\SessionMovie;
use App\Models\SessionSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    use HasFactory;

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'session_movies')->using(SessionMovie::class)->withTimestamps();
    }

    public function moviesWithSchedules(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'session_schedules')->using(SessionSchedule::class)->withTimestamps()->withPivot('schedule_id');
    }

    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'session_schedules')->using(SessionSchedule::class)->withTimestamps()->withPivot('movie_id');
    }
}
