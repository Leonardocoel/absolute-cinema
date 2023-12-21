<?php

namespace App\Http\Controllers\RootAdmin;

use Inertia\Inertia;
use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ReportController extends Controller
{

    public function index()
    {

        try {
            $movies = Movie::select(['id', 'title', 'release_date'])
                ->withCount('reservations as views')
                ->withSum('reservations as total', 'price')
                ->orderByDesc('release_date')->get();


            $moviesWeek = Movie::select(['id', 'title', 'release_date'])->whereRelation('schedules', 'start_time', '>=', now()->subDays(7))
                ->withCount(['reservations as views' => fn ($q) => $q
                    ->whereRelation('sessionSchedule.schedule', 'start_time', '>=', now()->subDays(7))])
                ->withSum(['reservations as total' => fn ($q) => $q
                    ->whereRelation('sessionSchedule.schedule', 'start_time', '>=', now()->subDays(7))], 'price')
                ->orderByDesc('views')->get();
        } catch (\Exception $e) {
            dd($e);
        }

        return Inertia::render('RootAdmin/Dashboard', [
            'movies' => $movies,
            'moviesWeek' => $moviesWeek,
        ]);
    }
}
