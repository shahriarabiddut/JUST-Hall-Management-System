<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\BalanceController;

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
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email','regex:/(.+)@(.+)\.(.+)/i', 'max:255', 'unique:'.User::class],
            'rollno' => ['required', 'integer', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'rollno' => $request->rollno,
        //     'password' => Hash::make($request->password),
        // ]);
        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->rollno = $request->rollno;
        $user->password = Hash::make($request->password);
        $user->save();
        
        //Creating Balance account for student
        $BalanceController = new BalanceController();
        $BalanceController->store($user->id);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
