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
    public function __construct()
    {
        // $this->authorizeResource(Movie::class, 'filme');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::id())->load(['cinemas']);
        $cinema = $user->cinemas[0];

        try {
            $query = DB::table('movies as m')
                ->join('session_schedules as ss', 'ss.movie_id', '=', 'm.id')
                ->join('schedules as sc', 'sc.id', '=', 'ss.schedule_id')
                ->join('sessions as s', 's.id', '=', 'ss.session_id')
                ->join('reservations as r', 'r.session_schedule_id', '=', 'ss.id')
                ->select('m.id', 'm.title', 'm.release_date', DB::raw('COUNT(m.id) as views'), DB::raw('SUM(price) as total'))
                ->where('s.cinema_id', '=', $cinema->id)
                ->groupBy('m.id');

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $filme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $filme)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $filme)
    {
    }
}
