<?php

namespace Tests\Testes\RootAdmin;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Cinema;
use App\Models\UserAccount;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;



    public function test_index_returns_view_with_users_and_cinemas(): void
    {

        $this->seed(UserSeeder::class);

        $user = User::whereRelation('roles', 'role_name', 'root_admin')->first();

        $response = $this->actingAs($user)->get('/admin/usuarios');


        $response->assertInertia(
            fn (Assert $page) =>
            $page->component('RootAdmin/User/Index')
                ->has('users')
                ->has('cinemasWithoutAdmin')
        );
    }

    public function test_store_creates_user_with_user_account_and_role()
    {
        $this->seed(UserSeeder::class);



        $this->actingAs(User::whereRelation('roles', 'role_name', 'root_admin')->first());

        $cinema = Cinema::factory()->create();
        $role = Role::where('role_name', 'cinema_admin')->first();

        $data = [
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password',
            "name" => fake($locale = 'pt_BR')->name(),
            "cpf" => fake()->cpf(),
            'role_id' =>  $role->id,
            'cinema_id' => $cinema->id,
        ];


        $this->post("/admin/usuarios/",  $data);



        $this->assertDatabaseCount('users', 4);
        $this->assertDatabaseCount('user_accounts', 1);
        $this->assertDatabaseCount('role_users', 4);

        $this->get('/admin/usuarios')->assertInertia(
            fn (Assert $page) =>
            $page->component('RootAdmin/User/Index')
                ->has('users', 4)
                ->has('cinemasWithoutAdmin')
        );
    }

    public function test_show_returns_view_with_user()
    {
        $this->seed(UserSeeder::class);

        $this->actingAs(User::whereRelation('roles', 'role_name', 'root_admin')->first());

        $user = User::factory()->create();

        $response = $this->get("/admin/usuarios/" . $user->id);

        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('RootAdmin/User/Show')
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

        $this->actingAs(User::whereRelation('roles', 'role_name', 'root_admin')->first());

        $user = User::factory()->has(UserAccount::factory())->create();

        $data = [
            'email' => 'person@example.com',
            'name' => 'Person',
            'cpf' => '057.265.700-57',
        ];

        $this->put("/admin/usuarios/" . $user->id, $data);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $data['email'],
        ]);

        $this->assertDatabaseHas('user_accounts', [
            'user_id' => $user->id,
            'name' => $data['name'],
            'cpf' => $data['cpf'],
        ]);


        $this->get("/admin/usuarios/" . $user->id)
            ->assertInertia(
                fn (Assert $page) => $page
                    ->component('RootAdmin/User/Show')
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

    public function test_destroy_soft_deletes_user()
    {
        $this->seed(UserSeeder::class);
        $this->actingAs(User::whereRelation('roles', 'role_name', 'root_admin')->first());

        $user = User::factory()->has(UserAccount::factory())->create();


        $this->delete(("/admin/usuarios/" . $user->id));

        $this->assertSoftDeleted($user);

        $this->get('/admin/usuarios')->assertInertia(
            fn (Assert $page) =>
            $page->component('RootAdmin/User/Index')
                ->has('users', 3)
        );
    }
}
