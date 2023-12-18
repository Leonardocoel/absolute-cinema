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

    /**
     * Display a listing of the resource.
     */
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
