<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }

    public function do_login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user_name = $request->input('username');
        $password = $request->input('password');

        if(Auth::attempt(['username'=>$user_name,'password' => $password]))
        {
            $user = User::where('username',$user_name)->first();
            Auth::login($user);
            return redirect('organisation-list')->withMessage('User login Succesffully');
        }else{
            return redirect('login')->withMessage('error login');
        }
    }

    public function user_logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
