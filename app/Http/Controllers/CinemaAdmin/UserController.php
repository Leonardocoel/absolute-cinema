<?php

namespace App\Http\Controllers\CinemaAdmin;

use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Reservation;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'usuario');
    }


    protected function admin()
    {
        $user = User::find(Auth::id())->load(['cinemas']);

        return ["cinema" => $user->cinemas[0], 'user' => $user];
    }


    public function index()
    {

        $cinema = $this->admin()['cinema'];

        $users = User::whereRelation('cinemas', 'cinema_id', $cinema->id)
            ->with(['roles' => fn ($q) => $q->where('cinema_id', $cinema->id)])
            ->without('cinemas')
            ->orderBy('id', 'asc')
            ->get();

        return Inertia::render('CinemaAdmin/User/Index', [
            'users' => $users,
            'cinema' => $cinema
        ]);
    }

    public function findUserBy(Request $request)
    {
        $request->validate(['email' => ['nullable', 'email'], 'cpf' => ['nullable', 'string']]);

        //if user exists but cant be registered return...

        //else
        $user = User::whereDoesntHave('roles', fn ($q) => $q->whereIn('role_id', [1, 2]))
            ->where(
                fn (Builder $q) => $q
                    ->whereHas('userAccount', fn ($q) => $q->where('cpf', $request->cpf))
                    ->orWhere('email', $request->email)
            )
            ->withOnly('userAccount')
            ->first();


        if (!$user) return  response()->json(['message' => 'Usuário não encontrado ou indisponível']);


        return response()->json(['user' => $user]);
    }



    public function create()
    {
        //* leva para uma pagina com as informações encontradas
    }


    public function store(StoreUserRequest $request)
    {
        //* vincula usuario ao cinema vigente e possibilita atualização de perfil
    }


    public function show(User $usuario)
    {
        $cinema = $this->admin()['cinema'];

        //* lista reservas relacionadas ao usuario, podendo gerenciar ou redirecionar para a pagina de gerenciamento

        $usuario->load([
            // 'reservations' => fn ($q) => $q->whereRelation('sessionSchedule.session', 'cinema_id', $cinema->id),
            'roles' => fn ($q) => $q->where('cinema_id', $cinema->id)
        ]);



        return Inertia::render('CinemaAdmin/User/Show', [
            'user' => $usuario
        ]);
    }


    public function update(UpdateUserRequest $request, User $usuario)
    {
        try {

            $usuario->userAccount->update(["name" => $request->name, "cpf" => $request->cpf]);
        } catch (\Exception $e) {

            dd($e);
        }
    }


    public function destroy(User $usuario)
    {
        $cinema = $this->admin()['cinema'];

        $usuario->cinemas()->detach($cinema->id);

        return to_route('usuarios.index');
    }
}
