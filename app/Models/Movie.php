<?php

namespace App\Models;

use App\Models\Session;
use App\Models\Schedule;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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


    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class);
    }

    public function reservations(): HasManyThrough
    {
        return $this->hasManyThrough(Reservation::class, Schedule::class);
    }
}
