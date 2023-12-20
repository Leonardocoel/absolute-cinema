<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\Session;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SessionSchedule extends Pivot
{
    use HasFactory;

    public $incrementing = true;


    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class, 'session_schedule_id');
    }
}
