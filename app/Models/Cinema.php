<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Session;
use App\Models\RoleUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        return $this->belongsToMany(User::class, 'role_users')->using(RoleUser::class)->withTimestamps()->withPivot('role_id');
    }

    public function admin(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users')->wherePivot('role_id', 2)->using(RoleUser::class)->withTimestamps()->withPivot('role_id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
