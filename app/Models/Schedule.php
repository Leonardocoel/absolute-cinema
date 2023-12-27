<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Movie;
use App\Models\Session;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    public $incrementing = true;


    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function movies(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function sessions(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
