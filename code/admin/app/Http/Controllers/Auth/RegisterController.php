<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use GuzzleHttp\Client;

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
    protected $redirectTo = '/admin';

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5'],
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
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://web']);
        $options = [
            'json' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'c_password' => $data['c_password']
            ]
        ];
         
        $response = $client->post('/app/api/register', $options);

        $user = new User();

        if($response->getStatusCode() == 200) {
            $json = json_decode($response->getBody()->getContents());
            $user->name = $json->success->user->name;
            $user->email = $json->success->user->email;
            $user->id = $json->success->user->id;

            request()->session()->put('authenticated',true);
            request()->session()->put('user', $user);
            request()->session()->put('auth_token', $json->success->token);
        }

        return $user;
    }
}
