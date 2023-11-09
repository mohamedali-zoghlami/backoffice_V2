<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fiche;

class sqlCon
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   try
        {
            DB::connection("mysql")->getPdo();
        }
        catch(Exception $e)
        {
            return redirect()->route("data")->with("error","Connexion avec MySQL est interrompu ");
        }
        return $next($request);
    }
}
