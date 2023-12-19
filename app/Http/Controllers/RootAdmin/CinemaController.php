<?php

namespace App\Http\Controllers\RootAdmin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Cinema;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Http\Requests\StoreCinemaUsersRequest;
use App\Http\Requests\UpdateCinemaAdminRequest;

class CinemaController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Cinema::class, 'cinema');
    }


    public function index()
    {
        try {

            $cinemas = Cinema::all()->load(['users.roles']);

            return Inertia::render('RootAdmin/Cinema/Index', [
                'cinemas' => $cinemas,
            ]);
        } catch (\Exception $e) {

            dd($e);
        }
    }


    public function store(StoreCinemaRequest $request)
    {
        try {

            Cinema::create($request->all());
        } catch (\Exception $e) {

            dd($e);
        }
    }

    public function show(Cinema $cinema)
    {
        try {

            $cinema->load(['users.roles', 'users.userAccount']);

            $endUsers = User::whereDoesntHave('roles', fn ($q) => $q->whereIn('role_id', [1, 2]))
                ->whereDoesntHave('cinemas', fn ($q) => $q->where('cinema_id', $cinema->id))
                ->with(['userAccount:user_id,name'])
                ->get('id');

            return Inertia::render('RootAdmin/Cinema/Show', [
                'cinema' => $cinema,
                'endUsers' => $endUsers
            ]);
        } catch (\Exception $e) {

            dd($e);
        }
    }



    public function update(UpdateCinemaRequest $request, Cinema $cinema)
    {
        try {

            $cinema->update([...$request->all()]);
        } catch (\Exception $e) {

            dd($e);
        }
    }

    public function alterAdmin(UpdateCinemaAdminRequest $request, Cinema $cinema)
    {
        $this->authorize('update', $cinema);

        try {

            $oldId = $cinema->admin->first()->id;

            $cinema->users()->syncWithoutDetaching([
                $oldId => ['role_id' => 3],
                $request->newId => ['role_id' => 2],
            ]);
        } catch (\Exception $e) {

            dd($e);
        }
    }

    public function addNewUsers(StoreCinemaUsersRequest $request, Cinema $cinema)
    {
        $this->authorize('update', $cinema);

        try {

            $cinema->users()->attach(
                [...$request->newIds],
                ['role_id' => 3]
            );
        } catch (\Exception $e) {

            dd($e);
        }
    }


    public function destroy(Cinema $cinema)
    {
        try {

            $cinema->delete();

            return to_route('cinemas.index');
        } catch (\Exception $e) {

            dd($e);
        }
    }
}
