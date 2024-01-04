<?php

namespace App\Services\Cinema;

use App\Models\Cinema;
use Illuminate\Database\Eloquent\Collection;

class CinemaService
{
    public function index($noAdmin = false): Collection
    {
        $cinemas = $noAdmin
            ? Cinema::whereDoesntHave('users', fn ($q) => $q->where('role', 'admin'))->get()
            : Cinema::all();

        return $cinemas;
    }
}
