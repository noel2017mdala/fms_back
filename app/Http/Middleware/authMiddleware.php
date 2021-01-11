<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class authMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        $query = DB::table('oauth_clients')
        ->where('id', 2)
        ->get();
        $data = '';

        foreach($query as $querySecret){
            $data =  $querySecret->secret;
        }

        // $response = Http::asForm()->post('http://passport-app.com/oauth/token', [
        //     'grant_type' => 'password',
        //     'client_id' => 3,
        //     'client_secret' => $data,
        //     'username' => $request->email,
        //     'password' => $request->password,
        //     'scope' => '*',
        // ]);

        $request->merge([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => $data,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*',
        ]);

        return $next($request);
    }
}
