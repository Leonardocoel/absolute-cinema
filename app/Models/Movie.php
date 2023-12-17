<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
