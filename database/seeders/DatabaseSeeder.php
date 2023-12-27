<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Seat;
use App\Models\User;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\Session;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        User::factory()->create(["email" => "admin@mail.com", 'role' => 'root_admin']);

        $movies =  Movie::factory(15)->create();
        $availableMovies = $movies->where('availability', true);

        $cinema = Cinema::factory()
            ->hasAttached(User::factory()->create(['email' => 'cinema@mail.com', 'role' => 'admin']))
            ->hasAttached(User::factory()->create(['email' => 'usuario@mail.com', 'role' => 'end_user']))
            ->hasAttached(User::factory(4)->create(['role' => 'end_user']))
            ->has(Ticket::factory(3))
            ->has(Room::factory()->state(['capacity' => 100])->has(Seat::factory(100)))
            ->has(Room::factory()->state(['capacity' => 200])->has(Seat::factory(200)))
            ->has(Room::factory()->state(['capacity' => 300])->has(Seat::factory(300)))
            ->has(Session::factory(5)->hasAttached($availableMovies))
            ->create();


        foreach ($cinema->sessions as $session) {
            foreach ($cinema->rooms as $room) {
                Schedule::factory(7)->recycle([$session, $room, $availableMovies->random()])->create();
            }
        }


        $users = $cinema->users->where('role', 'end_user');
        $seats = Seat::whereIn('room_id', $cinema->rooms->pluck('id'))->get();
        $schedules = Schedule::whereIn('session_id', $cinema->sessions->pluck('id'))->get();

        foreach ($schedules->random(30) as $schedule) {
            Reservation::factory()
                ->recycle([$users, $cinema->tickets, $schedule, $seats->where('room_id', $schedule->room_id)])
                ->create();
        }

        $cinemas = Cinema::factory(2)
            ->hasAttached(User::factory()->create(['role' => 'admin']))
            ->hasAttached(User::factory(5)->create(['role' => 'end_user']))
            ->has(Ticket::factory(3))
            ->has(Room::factory()->state(['capacity' => 100])->has(Seat::factory(100)))
            ->has(Room::factory()->state(['capacity' => 200])->has(Seat::factory(200)))
            ->has(Room::factory()->state(['capacity' => 300])->has(Seat::factory(300)))
            ->has(Session::factory(5)->hasAttached($availableMovies))
            ->create();

        foreach ($cinemas as $cinema) {
            foreach ($cinema->sessions as $session) {
                foreach ($cinema->rooms as $room) {
                    Schedule::factory(7)->recycle([$session, $room, $availableMovies->random()])->create();
                }
            }


            $users = $cinema->users->where('role', 'end_user');
            $seats = Seat::whereIn('room_id', $cinema->rooms->pluck('id'))->get();
            $schedules = Schedule::whereIn('session_id', $cinema->sessions->pluck('id'))->get();

            foreach ($schedules->random(30) as $schedule) {
                Reservation::factory()
                    ->recycle([$users, $cinema->tickets, $schedule, $seats->where('room_id', $schedule->room_id)])
                    ->create();
            }
        }
    }
}
