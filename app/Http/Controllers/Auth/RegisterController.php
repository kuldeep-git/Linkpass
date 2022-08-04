<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        $request->session()->flash('alert-success', 'Your account has been successfully created. Please verify your accout from register email.');
        return $this->registered($request, $user)
            ?: redirect(route('home'));
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function creatorRegister()
    {
        return view('auth.register', array('isCreator' => 1));
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
            'account_name' => ['required', 'string', 'min:10', 'max:100', 'unique:users'],
            'password' => ['required', 'min:8','regex:/[0-9]/', 'regex:/[@$!%*#?&]/', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'user_type'  => $data['user_type'],
            'is_company' => ($data['user_type'] == 1) ? $data['is_company'] : '0',
            'password'   => Hash::make($data['password']),
        ]);
    }
}
