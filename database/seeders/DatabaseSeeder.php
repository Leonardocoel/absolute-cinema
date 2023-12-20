<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Room;
use App\Models\Seat;

use App\Models\User;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Ticket;
use App\Models\Session;
use App\Models\RoleUser;
use App\Models\Schedule;
use App\Models\Reservation;
use App\Models\UserAccount;
use App\Models\SessionSchedule;
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


        $roles = DB::table('roles')->get();


        $adminId = $roles->where('role_name', 'cinema_admin')->value('id');
        $endUserId = $roles->where('role_name', 'end_user')->value('id');
        $rootAdminId = $roles->where('role_name', 'root_admin')->value('id');


        $rootAdmin = User::factory()->has(UserAccount::factory())->create(['email' => 'root_admin@mail.com']);
        DB::table('role_users')->insert(['user_id' => $rootAdmin->id, 'role_id' => $rootAdminId, 'created_at' => $now, 'updated_at' => $now]);


        $movies =  Movie::factory(15)->create();


        $cinema = Cinema::factory()
            ->hasAttached(User::factory()->has(UserAccount::factory())->create(['email' => 'cinema@mail.com']), ['role_id' => $adminId])
            ->hasAttached(User::factory()->has(UserAccount::factory())->create(['email' => 'usuario@mail.com']), ['role_id' => $endUserId])
            ->hasAttached(User::factory(4)->has(UserAccount::factory()), ['role_id' => $endUserId])
            ->has(Ticket::factory(3))
            ->create();


        Session::factory(4)
            ->recycle($cinema)
            ->hasAttached(Schedule::factory()->lastWeek(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory()->lastWeek(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory()->lastWeek(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory()->lastWeek(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached($movies)
            ->create();



        $cinemas = Cinema::factory(4)
            ->hasAttached(User::factory()->has(UserAccount::factory()), ['role_id' => $adminId])
            ->hasAttached(User::factory(5)->has(UserAccount::factory()), ['role_id' => $endUserId])
            ->has(Ticket::factory(3))
            ->create();


        Session::factory(4)
            ->recycle($cinemas)
            ->hasAttached(Schedule::factory()->lastWeek(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory()->lastWeek(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached(Schedule::factory(), ['movie_id' => $movies->random()->id])
            ->hasAttached($movies)
            ->create();



        $rooms = Room::all(['id', 'accessibility']);

        foreach ($rooms as $room) {
            for ($row = 'A'; $row <= 'E'; $row++) {
                for ($seatNumber = 1; $seatNumber <= 6; $seatNumber++) {
                    DB::table('seats')->insert([
                        'room_id' => $room->id,
                        'seat_number' => $seatNumber,
                        'seat_row' => $row,
                        'is_accessible' => $room->accessibility ? fake()->boolean() : false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        $users = UserAccount::whereRelation('user.roles', 'role_id', 3)->get();

        foreach ($cinemas as $cinema) {
            $cinema->users()->attach($users->pluck('id'), ['role_id' => 3]);
        }

        $sessionSchedules =  DB::table('session_schedule')->get()->pluck('id');
        $tickets = Ticket::all();
        $seats = Seat::all();

        foreach ($sessionSchedules as $ss) {
            Reservation::factory(21)
                ->recycle($users)
                ->recycle($seats)
                ->recycle($movies)
                ->recycle($tickets)
                ->recycle([...$cinemas, $cinema])
                ->create(['session_schedule_id' => $ss]);
        }
    }
}
