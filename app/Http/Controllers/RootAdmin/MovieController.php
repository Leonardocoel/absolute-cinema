<?php

namespace App\Http\Controllers\RootAdmin;

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
            $movies = Movie::all();


            return Inertia::render('RootAdmin/Movie/Index', [
                'movies' => $movies,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function store(StoreMovieRequest $request)
    {
        try {
            DB::beginTransaction();

            if ($request->hasFile('image')) {
                $path = $request->image->store('movies', 'public');

                $movie = $request->except('image');

                Movie::create([...$movie, 'image_url' => $path]);
            };

            DB::commit();
        } catch (\Exception $e) {
            Storage::disk('public')->delete($path);
            DB::rollBack();
            dd($e);
        }
    }


    public function show(Movie $filme)
    {
        try {

            $filme->release_date_raw = Carbon::parse($filme->release_date)->format('Y-m-d');

            return Inertia::render('RootAdmin/Movie/Show', [
                'movie' => $filme,
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public function update(UpdateMovieRequest $request, Movie $filme)
    {
        try {
            DB::beginTransaction();

            $filme->update([...$request->except('image')]);

            if ($request->hasFile('image')) {
                $path = $request->image->store('movies', 'public');

                $filme->update(['image_url' => $path]);
            };
            DB::commit();
        } catch (\Exception $e) {
            Storage::disk('public')->delete($path);
            DB::rollBack();
            dd($e);
        }
    }


    public function destroy(Movie $filme)
    {
        try {

            Storage::disk('public')->delete($filme->image_url);

            $filme->delete();

            return to_route('filmes.index');
        } catch (\Exception $e) {

            dd($e);
        }
    }
}
