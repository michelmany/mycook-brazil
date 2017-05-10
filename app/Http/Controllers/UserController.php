<?php

namespace App\Http\Controllers;

use App\Buyer;
use App\Http\Requests\BuyerRequest;
use App\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')], $request->input('remember'))) {
            return redirect('/');
        }
        return redirect()->route('authHome');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function registerGet()
    {
        return view('user.register');
    }

    public function registerPost(BuyerRequest $request)
    {
        $user = User::create([
            'name'=> $request->input('name'),
            'cpf'=> $request->input('cpf'),
            'active'=>true,
            'role'=>'user',
            'email'=> $request->input('email'),
            'password'=> bcrypt($request->input('password')),
        ]);

        $buyer = new Buyer;

        $buyer->phone = $request->input('phone');
        $buyer->birth = $request->input('birth');

        $buyer->user()->associate($user);
        return redirect()->route('authHome');
    }
}
