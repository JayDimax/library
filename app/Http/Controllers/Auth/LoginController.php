<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Redirect users after login based on role.
     *
     * @return string
     */
    protected function redirectTo()
    {
        if (Auth::user()->role === 'admin') {
            return '/dashboard'; // Redirect admin users to the admin dashboard
        }
        return '/user'; // Redirect regular users to the home page
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    
    public function logout()
    {
        Auth::logout(); // Log out the user   
        return redirect('/'); // Redirect to homepage or login page
    }
    
}

