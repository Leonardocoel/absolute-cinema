<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
