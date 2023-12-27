<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create(["email" => "admin@mail.com", 'role' => 'root_admin']);
        User::factory()->create(["email" => "cinema@mail.com", 'role' => 'admin']);
        User::factory()->create(["email" => "usuario@mail.com", 'role' => 'end_user']);
    }
}
