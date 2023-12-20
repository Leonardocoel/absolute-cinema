<?php

namespace App\Http\Controllers\CinemaAdmin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Cinema;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateCinemaRequest;



class CinemaController extends Controller
{

    public function show(Cinema $cinema)
    {
        $this->authorize('view', $cinema);

        try {

            $user = User::find(Auth::id())->load(['cinemas']);
            $cinema = $user->cinemas[0];

            $cinema->load(['users.roles', 'users.userAccount']);


            return Inertia::render('CinemaAdmin/Cinema/Show', [
                'cinema' => $cinema,
            ]);
        } catch (\Exception $e) {

            dd($e);
        }
    }


    public function update(UpdateCinemaRequest $request)
    {
        try {
            $user = User::find(Auth::id())->load(['cinemas']);
        } catch (\Exception $e) {
            dd($e);
        }

        $cinema = $user->cinemas[0];

        $this->authorize('update', $cinema);

        $cinema->update($request->validated());
    }
}
