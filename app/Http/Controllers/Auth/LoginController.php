<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActiveDirectoryService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $key = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => 'Cok fazla deneme. Lütfen ' . $seconds . ' saniye sonra tekrar deneyin.']);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $ad = new ActiveDirectoryService();
        $userData = $ad->authenticate($credentials['email'], $credentials['password']);
        if (!$userData) {
            RateLimiter::hit($key, 60);
            return back()->withErrors(['email' => 'Giris basarisiz']);
        }

        RateLimiter::clear($key);

        $user = User::updateOrCreate(
            ['email' => $credentials['email']],
            [
                'name' => $userData['displayname'][0] ?? $credentials['email'],
                'password' => Hash::make($credentials['password']),
                'role' => 'student'
            ]
        );

        Auth::login($user);
        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
