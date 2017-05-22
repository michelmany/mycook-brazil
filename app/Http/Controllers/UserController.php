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
        $data['buyer']['type_delivery'] = implode(',', $data['buyer']['type_delivery']);

        $email = $data['user']['email'];
        $password = bcrypt(bin2hex(openssl_random_pseudo_bytes(8)));
        $data['user']['role'] = 'vendedor';

        $user = User::firstOrCreate(
            [ 'email' => $email],
            array_merge($data['user'], ['password' => $password])
        );
        
        Address::create(array_merge($data['address'], ['user_id'=>$user['id']]));
        $seller_data = array_merge($data['buyer'], ['user_id'=>$user['id']]);
        $seller = Seller::create($seller_data);

        foreach ($data['images']['estabelecimento'] as $image) {
            FotoEstabelecimento::create([
                'url' => $image,
                'seller_id' => $seller->id
            ]);
        }

        \Mail::to(config('mail.contact'))->send(new SellerAdminRegisterMail());
        \Mail::to($user->email)->send(new SellerRegisterMail);

        return redirect()->route('queroVender');
    }
}
