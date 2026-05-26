<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Store additional session data (matches legacy profile_image, bio, etc.)
            $user = Auth::user();
            session([
                'user_id'    => $user->id,
                'user_name'  => $user->name,
                'user_role'  => $user->role ?? 'user',
                'user_bio'   => $user->bio ?? '',
                'user_image' => $user->profile_image ?? 'default.jfif',
            ]);

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'អ៊ីមែល ឬ លេខសម្ងាត់មិនត្រឹមត្រូវ!',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'          => $validated['fullname'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'role'          => 'user',
            'profile_image' => 'default.jfif',
        ]);

        Auth::login($user);

        session([
            'user_id'    => $user->id,
            'user_name'  => $user->name,
            'user_role'  => $user->role,
            'user_bio'   => '',
            'user_image' => 'default.jfif',
        ]);

        return redirect()->route('home');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
