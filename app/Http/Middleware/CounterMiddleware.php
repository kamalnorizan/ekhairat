<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CounterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $ipAddress = $request->ip();
        $date = Carbon::now()->toDateString();
    
        // Check if this IP has visited the site today
        $visit = DB::table('tblcounter')
                    ->where('ip_address', $ipAddress)
                    ->where('tarikh', $date)
                    ->first();
    
        if (!$visit) {
            DB::table('tblcounter')->insert(['ip_address' => $ipAddress, 'tarikh' => $date]);
        }
    
        return $next($request);
    }
}



