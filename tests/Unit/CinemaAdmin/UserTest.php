<?php

namespace Tests\Unit\CinemaAdmin;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Cinema;
use App\Models\UserAccount;
use Database\Seeders\UserSeeder;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;



    public function test_index_returns_view_with_users_and_cinemas(): void
    {

        $this->seed(UserSeeder::class);

        $user = User::whereRelation('roles', 'role_name', 'cinema_admin')->first();

        $response = $this->actingAs($user)->get('/cinema/usuarios');


        $response->assertInertia(
            fn (Assert $page) =>
            $page->component('CinemaAdmin/User/Index')
                ->has('users')
                ->has('cinema')
        );
    }

    public function test_find_user_by_cpf_or_email_user_registred()
    {
        $this->seed(UserSeeder::class);
        $admin = User::whereRelation('roles', 'role_name', 'cinema_admin')->first();
        $this->actingAs($admin);

        $cinema = Cinema::factory()->create();
        $role = Role::where('role_name', 'end_user')->first();

        $user = User::factory()->has(UserAccount::factory())
            ->hasAttached($role, ['cinema_id' => $cinema->id])->create();

        $this->post("/cinema/usuarios/find", ["email" => $user->email, "cpf" => ''])
            ->assertJson(['user' => ['id' => $user->id]]);

        $this->post("/cinema/usuarios/find", ["email" => '', "cpf" => $user->userAccount->cpf])
            ->assertJson(['user' => ['id' => $user->id]]);

        $this->post("/cinema/usuarios/find", ["email" => $admin->email, "cpf" => ''])
            ->assertJson(['message' => 'Usuário não encontrado ou indisponível']);
    }

    public function test_show_returns_view_with_user()
    {
        $this->seed(UserSeeder::class);
        $this->actingAs(User::whereRelation('roles', 'role_name', 'cinema_admin')->first());

        $user = User::whereRelation('roles', 'role_name', 'end_user')->first();

        $this->get("/cinema/usuarios/" . User::factory()->create()->id)
            ->assertForbidden();

        $this->get("/cinema/usuarios/" . $user->id)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('CinemaAdmin/User/Show')
                    ->has(
                        'user',
                        fn (Assert $page) => $page
                            ->where('id', $user->id)
                            ->etc()
                    )
            );
    }

    public function test_update_updates_user_and_user_account()
    {
        $this->seed(UserSeeder::class);

        $this->actingAs(User::whereRelation('roles', 'role_name', 'cinema_admin')->first());

        $user = User::whereRelation('roles', 'role_name', 'end_user')->first();
        UserAccount::factory()->for($user)->create();


        $data = [
            'email' => $user->email,
            'name' => 'Person',
            'cpf' => '057.265.700-57',
        ];

        $this->get("/cinema/usuarios/" . User::factory()->create()->id)
            ->assertForbidden();

        $this->put("/cinema/usuarios/" . $user->id, $data);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $data['email'],
        ]);

        $this->assertDatabaseHas('user_accounts', [
            'user_id' => $user->id,
            'name' => $data['name'],
            'cpf' => $data['cpf'],
        ]);


        $this->get("/cinema/usuarios/" . $user->id)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('CinemaAdmin/User/Show')
                    ->has(
                        'user',
                        fn (Assert $page) => $page
                            ->where('id', $user->id)
                            ->where('email', $data['email'])
                            ->where('user_account.user_id',  $user->id)
                            ->where('user_account.name', $data['name'])
                            ->where('user_account.cpf',  $data['cpf'])
                            ->etc()
                    )
            );
    }

    public function test_destroy_detach_user()
    {

        $this->seed(UserSeeder::class);
        $admin = User::whereRelation('roles', 'role_name', 'cinema_admin')->first();
        $user = User::whereRelation('roles', 'role_name', 'end_user')->first();
        $role = Role::where('role_name', 'end_user')->first();
        $this->actingAs($admin);


        $this->delete(("/cinema/usuarios/" . $user->id));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
        ]);
        $this->assertDatabaseMissing('role_users', [
            'user_id' => $user->id,
            'role_id' => $role->id,
            'cinema_id' => $admin->cinemas[0]->id
        ]);
        $this->get('/cinema/usuarios')->assertInertia(
            fn (Assert $page) =>
            $page->component('CinemaAdmin/User/Index')
                ->has('users', 1)
        );
        $this->delete("/cinema/usuarios/" . User::factory()->create()->id)
            ->assertForbidden();
    }
}
