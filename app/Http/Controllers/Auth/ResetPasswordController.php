<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
//        $this->middleware('guest');
    }


    public function reset()
    {
        $this->validate(request(), [
            'password' => "required|confirmed"
        ]);

        auth()->user()->update([
            'password' => bcrypt(request('password'))
        ]);

        return redirect($this->redirectTo);
    }
}
