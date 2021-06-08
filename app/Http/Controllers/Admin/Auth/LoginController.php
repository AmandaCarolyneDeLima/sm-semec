<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\MessageBag;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Auth\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showLoginForm()
    {
        return view('auth.login', [
            'loginRoute' => 'login',
            'forgotPasswordRoute' => 'password.request',
        ]);
    }

    public function login(Request $request)
    {
        $userData = array(
            'CPF'  => $request->get('CPF'),
            'password' => $request->get('password'),
        );

        if (!Auth::attempt($userData)) {
            return redirect('admin/login')->with('fail', 'Usuário ou senha incorretas.');
        }

        return redirect('admin')->with('success', 'Login efetuado com sucesso.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin');
    }
}
