<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\UserAccount;

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

        $rootAdmin = User::factory()->has(UserAccount::factory())->create([
            'email' => 'root_admin@mail.com',
        ]);

        $rootAdminId = DB::table('roles')->where('role_name', 'root_admin')->value('id');

        DB::table('user_roles')->insert([
            'user_id' => $rootAdmin->id,
            'role_id' => $rootAdminId,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        User::factory()->count(10)->has(UserAccount::factory())->create();
    }
}
