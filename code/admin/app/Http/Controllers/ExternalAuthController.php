<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class ExternalAuthController extends Controller
{
    // private $httpHelper;

    // public function __contruct() {
    //     $this->httpHelper = new GuzzleHttp\Client([
    //         'base_uri' => 'http://web'
    //     ]);

    //     parent::__construct();
    // }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm() {
        return view("auth.login");
    }

    /**
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request) {
        try {
            $apiClient = new \GuzzleHttp\Client([
                'base_uri' => 'http://web'
            ]);

            $result = $apiClient->post('/app/api/login', [
                'json' => [
                    'email' => $request->input('email'),
                    'password' => $request->input('password')
                ]
            ]);

            $json = json_decode($result->getBody()->getContents());
            $user = new User();

            $user->id = $json->success->user->id;
            $user->email = $json->success->user->email;
            $user->name = $json->success->user->name;
            $user->password = '1828182818381';

            $request->session()->put('authenticated',true);
            $request->session()->put('user', $user);
            $request->session()->put('auth_token', $json->success->token);

            Auth::login($user);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $request->session()->forget('authenticated');
            $request->session()->forget('user');
            return redirect()->back()->with('error', 'The credentials do not match our records');
        } catch (\Exception $e) {
        }

        // return $user;

        return redirect('/admin');
    }

    /**
     * @param Illuminate\Http\Request $request 
     * @return type
     */
    public function logout(Request $request) {
        $request->session()->forget('authenticated');
        $request->session()->forget('user');
        $request->session()->forget('auth_token');
        return redirect()->action("Auth\LoginController@showLoginForm");
    }
}
