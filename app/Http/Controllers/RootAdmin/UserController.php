<?php

namespace App\Http\Controllers\RootAdmin;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use App\DataTransferObjects\UserDTO;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreUserRequest;
use App\Services\User\UserService;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Redirect;
use App\Services\Cinema\CinemaService;
use App\Http\Resources\RootAdmin\UserResource;
use App\Http\Resources\RootAdmin\CinemaResource;

class UserController extends Controller
{

    public function __construct(
        protected UserService $userService,
        protected CinemaService $cinemaService
    ) {
        $this->authorizeResource(User::class, 'usuario');
    }


    public function index(): Response
    {
        return Inertia::render('RootAdmin/User/Index', [
            'users' => UserResource::collection($this->userService->index()),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render(
            'RootAdmin/User/Create',
            [
                'cinemasWithoutAdmin' => CinemaResource::collection($this->cinemaService->index(noAdmin: true))
            ]
        );
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['cinemaId']);

        $this->userService->store(
            new UserDTO(...$data, id: null),
            $request->validated('cinemaId')
        );

        return Redirect::route('admin.usuarios.index')->with('message', 'Usuário criado.');
    }

    public function show(User $usuario): Response
    {
        return Inertia::render('RootAdmin/User/Show', [
            'user' => new UserResource($usuario->load('cinemas'))
        ]);
    }

    public function update(UpdateUserRequest $request, User $usuario): void
    {
        $data = $request->validated();
        $this->userService->update(
            new UserDTO(...$data, id: null, email: null, password: null, role: null),
            $usuario
        );
    }

    public function destroy(User $usuario): RedirectResponse
    {

        $this->userService->destroy($usuario);

        return Redirect::route('admin.usuarios.index')->with('message', "Usuário deletado");
    }
}
