<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = $request->user()->roles[0]->role_name;
                switch ($role) {
                    case 'root_admin':
                        return redirect('/admin/dashboard');
                        break;
                    case 'cinema_admin':
                        return redirect('/cinema/dashboard');
                        break;
                    case 'end_user':
                        return redirect('/dashboard');
                        break;
                    default:
                        return  abort(403, 'Unauthorized action.');
                }
            }
        }

        return $next($request);
    }
}
