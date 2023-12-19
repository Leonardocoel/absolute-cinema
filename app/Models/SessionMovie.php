<?php

namespace App\Models;

use App\Models\Movie;
use App\Models\Session;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionMovie extends Pivot
{
    public $incrementing = true;


    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
