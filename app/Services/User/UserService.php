<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\DataTransferObjects\UserDTO;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function index(): LengthAwarePaginator
    {
        $users = User::paginate();

        return $users;
    }

    public function store(UserDTO $dto, int $cinemaId): void
    {
        try {
            DB::beginTransaction();

            $user = User::Create([
                'email' => $dto->email,
                'password' => $dto->password,
                'name' => $dto->name,
                'cpf' => $dto->cpf,
                'role' => $dto->role,
            ]);

            $user->cinemas()->attach($cinemaId);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(UserDTO $dto, User $usuario)
    {
        try {
            DB::beginTransaction();

            $usuario->update(['name' => $dto->name, 'cpf' => $dto->cpf]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function destroy(User $usuario)
    {
        $usuario->delete();
    }
}
