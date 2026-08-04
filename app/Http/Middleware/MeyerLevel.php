<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class MeyerLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->route()->meyer) {
            if (Session::has('meyer')) {
                if (in_array(Session::get('meyer'), array("mil", "mtl", "manager"))) {
                    if (Session::get('meyer') != $request->route()->meyer) {
                        Auth::guard('web')->logout();
                        Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();

                        $request->session()->flush();
                        $request->session()->all();
                        if (isset($_SERVER['HTTP_COOKIE'])) {
                            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                            foreach($cookies as $cookie) {
                                $parts = explode('=', $cookie);
                                $name = trim($parts[0]);
                                setcookie($name, '', time()-1000);
                                setcookie($name, '', time()-1000, '/');
                            }
                        }
                        return redirect()->intended(route('login'));
                    }
                }

            }
            // URL::defaults(['meyer' => $request->route()->meyer]);
            // \Config::set('database.default', $request->route()->meyer);
            if (isset($_GET['db'])) {
                dump('Database is connected. Database Name is : ' . DB::connection()->getDatabaseName());
            }
        }
        return $next($request);
    }
}
