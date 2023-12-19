<?php

namespace App\Http\Controllers\RootAdmin;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'usuario');
    }


    public function index()
    {

        $users = User::all()->load(['userAccount', 'roles']);

        $cinemasWithoutAdmin = Cinema::whereDoesntHave('users', fn ($q) => $q->where('role_id', 2))->get(['name', 'id']);


        return Inertia::render('RootAdmin/User/Index', [
            'users' => $users,
            'cinemasWithoutAdmin' => $cinemasWithoutAdmin,
        ]);
    }


    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create($request->only(['email', 'password']));


            $user->userAccount()->create($request->only(['name', 'cpf']));

            if ($request->role_id === 2) {
                $cinemaId =  $request->cinema_id;
                $hasAdmin = Cinema::where('id', $cinemaId)->whereHas('users', fn ($q) => $q->where('role_id', 2))->exists();

                if ($hasAdmin) {
                    return back()->withErrors(['create' => 'Cinema already has an admin']);
                }

                $user->roles()->attach($request->role_id, ['cinema_id' =>  $cinemaId]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }



    public function show(User $usuario)
    {

        $usuario->load(['userAccount', 'roles', 'cinemas']);


        return Inertia::render('RootAdmin/User/Show', [
            'user' => $usuario
        ]);
    }

    public function update(UpdateUserRequest $request, User $usuario)
    {
        try {
            DB::beginTransaction();

            $usuario->update(['email' => $request->email]);
            $usuario->userAccount->update(["name" => $request->name, "cpf" => $request->cpf]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            dd($e);
        }
    }


    public function destroy(User $usuario)
    {
        $usuario->delete();

        return to_route('usuarios.index');
    }
}
