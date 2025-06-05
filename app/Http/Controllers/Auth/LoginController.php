<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthTrait;

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

    // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->middleware('guest')->except('logout');
        // $this->middleware('auth')->only('logout');
    }

    public function loginForm($type)
    {

        return view('auth.login', compact('type'));
    }

    public function login(Request $request)
    {
         if ($request->isMethod('get')) {
        return redirect('/');
    }

        if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
            return $this->redirect($request);
        }
        return back()->withErrors(['email' => 'بيانات الدخول غير صحيحة']);
    }



       public function logout(Request $request,$type)
    {

        $guards = ['student','teacher','parent','web'];
        if (!in_array($type,$guards)) {
          return  abort(403,'Unauthorized logout guard');
        }
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
