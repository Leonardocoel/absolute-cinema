<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Movie;

use App\Models\Cinema;
use App\Models\UserAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('roles')->insert([
            ['role_name' => 'root_admin', 'created_at' => $now, 'updated_at' => $now],
            ['role_name' => 'cinema_admin', 'created_at' => $now, 'updated_at' => $now],
            ['role_name' => 'end_user', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $rootAdmin = User::factory()
            ->has(UserAccount::factory())
            ->create(['email' => 'root_admin@mail.com']);

        $rootAdminId = DB::table('roles')
            ->where('role_name', 'root_admin')
            ->value('id');

        DB::table('role_users')
            ->insert([
                'user_id' => $rootAdmin->id,
                'role_id' => $rootAdminId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

        $adminId = DB::table('roles')->where('role_name', 'cinema_admin')->value('id');
        $endUserId = DB::table('roles')->where('role_name', 'end_user')->value('id');

        Cinema::factory()
            ->hasAttached(User::factory()->has(UserAccount::factory())->create(['email' => 'cinema@mail.com']), ['role_id' => $adminId])
            ->hasAttached(User::factory()->has(UserAccount::factory())->create(['email' => 'usuario@mail.com']), ['role_id' => $endUserId])
            ->hasAttached(User::factory()->count(4)->has(UserAccount::factory()), ['role_id' => $endUserId])
            ->create();




        Cinema::factory()->count(4)
            ->hasAttached(User::factory()->has(UserAccount::factory()), ['role_id' => $adminId])
            ->hasAttached(User::factory()->count(5)->has(UserAccount::factory()), ['role_id' => $endUserId])
            ->create();

        Movie::factory()->count(16)->create();
    }
}
