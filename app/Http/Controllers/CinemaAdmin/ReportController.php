<?php

namespace App\Http\Controllers\CinemaAdmin;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{

    public function index()
    {
        $user = User::find(Auth::id())->load(['cinemas']);
        $cinema = $user->cinemas[0];;

        try {
            $query = DB::table('movies as m')
                ->join('session_schedule as ss', 'ss.movie_id', '=', 'm.id')
                ->join('schedules as sc', 'sc.id', '=', 'ss.schedule_id')
                ->join('sessions as s', 's.id', '=', 'ss.session_id')
                ->join('reservations as r', 'r.session_schedule_id', '=', 'ss.id')
                ->select('m.id', 'm.title', 'm.release_date', DB::raw('COUNT(m.id) as views'), DB::raw('SUM(price) as total'))
                ->where('s.cinema_id', '=', $cinema->id)
                ->groupBy('m.id');
        } catch (\Exception $e) {
            dd($e);
        }

        $movies = $query->orderByDesc('m.release_date')->get();

        $moviesWeek = $query->where('start_time', '>=', now()->subDays(7))->get();

        return Inertia::render('CinemaAdmin/Dashboard', [
            'movies' => $movies,
            'moviesWeek' => $moviesWeek,
        ]);
    }
}
