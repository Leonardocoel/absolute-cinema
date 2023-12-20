<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Cinema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $now = Carbon::now();

        DB::table('roles')->insert([
            ['role_name' => 'root_admin', 'created_at' => $now, 'updated_at' => $now],
            ['role_name' => 'cinema_admin', 'created_at' => $now, 'updated_at' => $now],
            ['role_name' => 'end_user', 'created_at' => $now, 'updated_at' => $now],
        ]);

        $roles = DB::table('roles')->get();



        $adminId = $roles->where('role_name', 'cinema_admin')->value('id');
        $endUserId = $roles->where('role_name', 'end_user')->value('id');
        $rootAdminId = $roles->where('role_name', 'root_admin')->value('id');

        $cinema = Cinema::factory()->create();

        User::factory()->hasAttached(Role::class, ['role_id' => $rootAdminId])->create();
        User::factory()->hasAttached(Role::class, ['role_id' => $adminId, 'cinema_id' => $cinema->id])->create();
        User::factory()->hasAttached(Role::class, ['role_id' => $endUserId, 'cinema_id' => $cinema->id])->create();
    }
}
