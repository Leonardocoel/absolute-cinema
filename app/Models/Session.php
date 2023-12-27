<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    use HasFactory;


    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }

    public function latestSchedule(): HasOne
    {
        return $this->hasOne(Schedule::class)->OfMany('day', 'max');
    }
}
