<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Auth\AdminLoginRequest;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.index');
    }
    
    public function login(AdminLoginRequest $request)
    {
        $data = ['phone' => $request->phone,
        'password' => $request->password];

        $need = Auth::attempt($data);

        if($need)
            return redirect()->route('calendar.index');
        
            return redirect()->back()->withInput($request->only('phone', 'remember'));
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

}
