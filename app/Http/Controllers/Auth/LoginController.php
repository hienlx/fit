<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    // protected $redirectTo = '/';

    protected $username;
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        $this->username = $this->findUsername();
    }

    public function findUsername()
    {
        $login = request()->input('login');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';
        $request->merge([
            $login_type => $request->input('login')
        ]);

        $this->validate($request, [
            $login_type    => 'required|exists:users',
            'password' => 'required',
        ]);

        if (auth()->attempt($request->only($login_type, 'password'), $request->get('remember'))) {
            if (auth()->user()->status)
            // dd($login_type);
                return redirect()->intended($this->redirectPath());
            else{
                auth()->logout();
                return redirect()->back()
                ->withInput()
                ->withErrors([
                    'password' => 'Tài khoản bị khóa!',
                ]);
            }
        }
        return redirect()->back()
            ->withInput()
            ->withErrors([
                'password' => 'Mật khẩu không đúng',
            ]);
    }
}
