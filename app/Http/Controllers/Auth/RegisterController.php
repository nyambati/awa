<?php

namespace App\Http\Controllers\Auth;


use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

use App\User;
use App\UserActivation;
use App\Profile;
use App\Mail\UserActivationEmail;
use App\Mail\UserWelcomeEmail;
use App\Events\UserAccountActivated;
use App\Events\UserRegistered;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
        $user = User::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $activate = UserActivation::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);

        event(new UserRegistered($user));
        return $user;
    }

    public function activate($token)
    {
        $activation = UserActivation::where('token', $token)->first();

        if (!isset($activation)) {
            return redirect('/login')
                ->with('warning', 'Email activation failed please try again later');
        }

        $user = $activation->user;

        if ($user->activated) {
            return redirect('/login')
                ->with('status', "Your account has already been activated!.");
        }

        $activation->user->activated = 1;
        $activation->user->save();

        // Generate user profile and registration number
        $accountNumber = $this->generateUserAccountNumber();
        $profile = new Profile(['account_number' => $accountNumber]);
        $activation->user->profile()->save($profile);
        //Delete activation user
        UserActivation::where('user_id', $user->id)->first()->delete();
        // Send activation successful Email
        event(new UserAccountActivated($user));

        return redirect('/login')
            ->with('status', "Your account has already been successfuly activated!.");
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
        return redirect('/login')
            ->with('status', 'Your account has been created successfully, check your email for the activation link');
    }

    protected function generateUserAccountNumber()
    {
        return 'AWA/' . mt_rand(10000000, 99999999) . '/' . strtoupper(str_random(3));
    }
}


