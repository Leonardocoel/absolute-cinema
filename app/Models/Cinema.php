<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cinema extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'name', 'cnpj', 'email', 'phone', 'address', 'city', 'state'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }


    public function latestSession(): HasOne
    {
        return $this->hasOne(Session::class)->latestOfMany();
    }
}
