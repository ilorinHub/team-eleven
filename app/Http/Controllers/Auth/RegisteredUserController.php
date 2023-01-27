<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:50', 'unique:'.User::class],
            'phone_number' => ['required', 'phone:AUTO,US,UK,GH,UG,KE,ZM,NG,RW', 'unique:'.User::class],
            // 'phone_number' => ['required', 'digits:11', new Ngmobile, 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        try {
            DB::beginTransaction();

            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->roles()->attach(\App\Models\Role::where('name', 'user')->first());

            DB::commit();

            event(new Registered($user));

            return redirect(RouteServiceProvider::EMAIL_VERIFICATION_NOTICE);

            // Auth::login($user);

            // return redirect(RouteServiceProvider::HOME);

        } catch(\Throwable $throwable) {
            DB::rollback();
        }
    }
}
