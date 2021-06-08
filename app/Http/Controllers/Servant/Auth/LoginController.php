<?php

namespace App\Http\Controllers\Servant\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
    * Only guests for "servant" guard are allowed except
    * for logout.
    *
    *@return void
    */
    public function __construct()
    {
        $this->middleware('guest:servant')->except('logout');
    }

    /**
    *
    * @return \Illuminate\View\View
    */
    public function showLoginForm()
    {
        return view('auth.login', [
            'loginRoute' => 'servant.login',
            'forgotPasswordRoute' => 'servant.password.request',
        ]);
    }

    /**
    *
    * @param  \Illuminate\Http\Request  $request
    * @return  \Illuminate\Http\RedirectResponse.
    */
    public function login(Request $request)
    {
        $userData = array(
            'CPF'  => $request->get('CPF'),
            'password' => $request->get('password'),
        );

        if (!Auth::guard('servant')->attempt($userData)) {
            return redirect('servant/login')->with('fail', 'Usuário ou senha incorretas.');
        }

        return redirect('servant')->with('success', 'Login efetuado com sucesso.');
    }

    /**
    *
    * @return  \Illuminate\Http\RedirectResponse.
    */
    public function logout()
    {
        Auth::guard('servant')->logout();
        return redirect()->route('servant.login');
    }
}
