<?php

namespace App\Http\Controllers;

use App\Address;
use App\Buyer;
use App\User;
use App\Seller;
use App\Http\Requests\BuyerRequest;
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

    public function sellerRegister()
    {
        return view('user.seller_register');
    }

    public function sellerRegisterPost(Request $request)
    {
        $data = $request->all();

        $email = $data['user']['email'];
        $password = bcrypt(bin2hex(openssl_random_pseudo_bytes(8)));

        $user = User::firstOrCreate(
            [ 'email' => $email],
            array_merge($data['user'], ['password' => $password])
        );
        Address::create(array_merge($data['address'], ['user_id'=>$user['id']]));
        Seller::create(array_merge($data['buyer'], ['user_id'=>$user['id']]));

        return redirect()->route('queroVender');
    }
}
