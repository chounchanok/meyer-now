<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if (Session::has('meyer')) {
            return redirect()->intended(Session::get('meyer'));
        }
        addJavascriptFile('assets/js/custom/authentication/sign-in/general.js');
        return view('pages.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        $request->user()->update(['last_login_at' => Carbon::now()->toDateTimeString(), 'last_login_ip' => $request->getClientIp()]);
        Session::put('meyer', $request->meyer);
        // return redirect()->intended(route('meyer.dashboard'));
        return redirect('/' . $request->meyer . '/dashboard/?' . time());
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->session()->flush();
        $request->session()->all();
        // session_destroy();
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 1000);
                setcookie($name, '', time() - 1000, '/');
            }
        }

        return redirect('/');
    }

    public function username()
    {
        return 'orisoft_code'; //or return the field which you want to use.
    }
}
