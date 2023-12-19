<?php

namespace App\Http\Controllers\CinemaAdmin;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Movie::class, 'filme');
    }


    public function index()
    {
        try {
            $movies = Movie::where('availability', true)->orderBy('release_date', 'desc')->get();


            return Inertia::render('CinemaAdmin/Movie/Index', [
                'movies' => $movies,
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
