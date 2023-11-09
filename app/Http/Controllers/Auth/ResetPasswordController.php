<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User1;
use Illuminate\Http\Request;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    public function resetPassword(Request $request)
    {
        $user=User1::on("sqlsrv")->where("email",$request->email)->first();
        if(!$user)
            return redirect()->back();
        try{
            $user->password=\Hash::make($request->password);
            $user->remember_token=$request->token;
            $user->timestamps=false;
            $user->setConnection("sqlsrv")->save();
            Auth::login($user);
            $user->timestamps=true;
            return redirect('/');
        }
        catch(e)
        {
            return redirect()->back();
        }
    }
}
