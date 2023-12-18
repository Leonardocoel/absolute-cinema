<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Movie;
use App\Models\Session;
use App\Models\SessionSchedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Schedule extends Model
{
    use HasFactory;

    public $incrementing = true;


    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class, 'session_schedules')->using(SessionSchedule::class)->withTimestamps()->withPivot('session_id');
    }

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'session_schedules')->using(SessionSchedule::class)->withTimestamps()->withPivot('movie_id');
    }
}
