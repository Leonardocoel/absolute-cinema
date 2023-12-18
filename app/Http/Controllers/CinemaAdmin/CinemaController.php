<?php

namespace App\Http\Controllers\CinemaAdmin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Cinema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Http\Requests\StoreCinemaUsersRequest;
use App\Http\Requests\UpdateCinemaAdminRequest;

class CinemaController extends Controller
{

    public function __construct()
    {
        // $this->authorizeResource(Cinema::class, 'cinema');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCinemaRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
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


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCinemaRequest $request)
    {
        try {


            $user = User::find(Auth::id())->load(['cinemas']);
            $cinema = $user->cinemas[0];

            $this->authorize('update', $cinema);


            $cinema->update([...$request->all()]);
        } catch (\Exception $e) {

            dd($e);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cinema $cinema)
    {
    }
}
