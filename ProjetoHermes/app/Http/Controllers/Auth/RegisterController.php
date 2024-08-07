<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Authenticate the user after registration
        auth()->login($user);

        return redirect()->route('login'); // Redirect to a home route or wherever you want
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'superadmin' => ['nullable', 'boolean'],
            'driver' => ['nullable', 'boolean'],
            'cnh' => ['nullable', 'string', 'max:20'],
            'vehicle' => ['nullable', 'string', 'max:255'],
            'vehicle_doc' => ['nullable', 'string', 'max:255'],
            'passenger_capacity' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Verifica se é superadmin ou motorista
        $isSuperAdmin = isset($data['superadmin']) && $data['superadmin'];
        $isDriver = isset($data['driver']) && $data['driver'];

        // Define 'usuario' como true se não for superadmin nem motorista
        $usuario = !$isSuperAdmin && !$isDriver;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'superadmin' => $isSuperAdmin,
            'driver' => $isDriver,
            'cnh' => $data['cnh'],
            'vehicle' => $data['vehicle'],
            'vehicle_doc' => $data['vehicle_doc'],
            'passenger_capacity' => $data['passenger_capacity'] ?? null,
            'usuario' => $usuario,
        ]);
    }
}
