<?php

namespace App\Http\Controllers\CinemaAdmin;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

class ReportController extends Controller
{

    public function index()
    {
        $user = User::find(Auth::id())->load(['cinemas']);
        $cinema = $user->cinemas[0];

        try {
            $query = DB::table('movies as m')
                ->join('session_schedule as ss', 'ss.movie_id', '=', 'm.id')
                ->join('schedules as sc', 'sc.id', '=', 'ss.schedule_id')
                ->join('sessions as s', 's.id', '=', 'ss.session_id')
                ->join('reservations as r', 'r.session_schedule_id', '=', 'ss.id')
                ->select('m.id', 'm.title', 'm.release_date', DB::raw('COUNT(m.id) as views'), DB::raw('SUM(price) as total'))
                ->where('s.cinema_id', '=', $cinema->id)
                ->groupBy('m.id');


            // cast data

            $movies = $query->orderByDesc('m.release_date')->get();

            $moviesWeek = $query->where('start_time', '>=', now()->subDays(7))->get();

            return Inertia::render('CinemaAdmin/Dashboard', [
                'movies' => $movies,
                'moviesWeek' => $moviesWeek,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function show(Movie $filme)
    {
        try {

            $filme->release_date_raw = Carbon::parse($filme->release_date)->format('Y-m-d');

            return Inertia::render('CinemaAdmin/Movie/Show', [
                'movie' => $filme,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
