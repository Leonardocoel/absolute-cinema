<?php

namespace App\Http\Controllers\RootAdmin;

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
    public function __construct()
    {
        // $this->authorizeResource(Movie::class, 'filme');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            $query = DB::table('movies as m')
                ->join('session_schedule as ss', 'ss.movie_id', '=', 'm.id')
                ->join('schedules as sc', 'sc.id', '=', 'ss.schedule_id')
                ->join('sessions as s', 's.id', '=', 'ss.session_id')
                ->join('reservations as r', 'r.session_schedule_id', '=', 'ss.id')
                ->select('m.id', 'm.title', 'm.release_date', DB::raw('COUNT(m.id) as views'), DB::raw('SUM(price) as total'))
                ->groupBy('m.id');

            //* cast release_date

            $movies = $query->orderByDesc('m.release_date')->get();

            $moviesWeek = $query->where('start_time', '>=', now()->subDays(7))->get();

            return Inertia::render('RootAdmin/Dashboard', [
                'movies' => $movies,
                'moviesWeek' => $moviesWeek,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
