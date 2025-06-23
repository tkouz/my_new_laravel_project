<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider; // ★このuse文がRouteServiceProvider::HOMEを使うために必要
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use App\Http\Requests\Auth\RegisteredUserRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisteredUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => null, // null許容ならnull、必要ならデフォルト値
            'self_introduction' => null, // null許容ならnull、必要ならデフォルト値
            'last_login_at' => null, // null許容ならnull
            'role' => 'general', // デフォルト値
            'is_active' => true, // デフォルト値
        ]);

        event(new Registered($user));

        Auth::login($user);

        // ★★★この行を修正します★★★
        return redirect(RouteServiceProvider::HOME); // ここをRouteServiceProvider::HOMEに
    }
}