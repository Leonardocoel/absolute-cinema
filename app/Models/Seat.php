<?php

namespace App\Models;

use App\Models\Room;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seat extends Model
{
    use HasFactory;


    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }


    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
