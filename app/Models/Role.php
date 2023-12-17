<?php

namespace App\Models;

use App\Models\User;
use App\Models\Cinema;
use App\Models\RoleUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;


    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_users')->using(RoleUser::class)->withTimestamps();
    }
}
