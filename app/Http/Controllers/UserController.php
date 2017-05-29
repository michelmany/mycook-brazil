<?php

namespace App\Http\Controllers;

use App\Address;
use App\Buyer;
use App\FotoEstabelecimento;
use App\Mail\BuyerAdminRegisterMail;
use App\Mail\BuyerRegisterMail;
use App\Mail\SellerAdminRegisterMail;
use App\Mail\SellerRegisterMail;
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
            $user = Auth::user();
            if ($user->addresses->first()->cep) {
                return redirect()->to('/minha-conta/enderecos');
            }
            return redirect()->to('/list');
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

        \Mail::to(config('mail.contact'))->send(new BuyerAdminRegisterMail);
        \Mail::to($user->email)->send(new BuyerRegisterMail);

        return redirect()->route('authHome')->with('success', 'Registro efetuado com sucesso, verifique seu email...');
    }

    public function sellerRegister()
    {
        return view('user.seller_register');
    }

    public function sellerRegisterPost(Request $request)
    {
        $data = $request->all();
        $data['user'] = (array)json_decode($data['user'][0]);
        $data['user']['seller'] = (array)$data['user']['seller'];
        $data['address'] = (array)json_decode($data['address'][0]);
        // dd($data);

        $data['user']['seller']['type_delivery'] = implode(',', $data['user']['seller']['type_delivery']);

        $email = $data['user']['email'];
        $password = bcrypt(bin2hex(openssl_random_pseudo_bytes(8)));
        $data['user']['role'] = 'vendedor';
        $data['user']['active'] = false;

        $user = User::firstOrCreate(
            [ 'email' => $email],
            array_merge($data['user'], ['password' => $password])
        );
        
        Address::create(array_merge($data['address'], ['user_id'=>$user['id']]));

        $seller_data = array_merge($data['user']['seller'], ['user_id'=>$user['id']]);
        $seller = Seller::create($seller_data);

        $file = $request->file('file');
        // dd($files);

        FotoEstabelecimento::create([
            'url' => $file,
            'seller_id' => $user['id']
        ]);


        \Mail::to(config('mail.contact'))->send(new SellerAdminRegisterMail());
        \Mail::to($user->email)->send(new SellerRegisterMail);

        // return redirect()->route('queroVender');
    }

}