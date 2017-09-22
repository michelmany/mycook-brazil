<?php


namespace App\Http\Controllers;

use App\Models\Buyer;
use App\Services\Moip\Customer\OrderService;
use App\User;
use App\Models\Address;
use Illuminate\Http\Request;
use Auth;

class MeController
{
    public function profile()
    {
        $user = \Auth::user();
        $user = User::find($user->id);

        $passwordIsNull = empty($user->password);
        unset($user->password);
        $buyer = \Auth::user()->buyer()->first();
        return view('me.profile', ['user'=>$user, 'buyer'=>$buyer, 'passwordIsNull'=>$passwordIsNull]);
    }

    public function profilePost(Request $request)
    {
        // dd($request);
        $user = \Auth::user();
        $user = User::find($user->id);

        $user->name = $request->input('user.name');
        $user->email = $request->input('user.email');
        $user->cpf = $request->input('user.cpf');
        $user->save();

        $buyer = $request->input('buyer');
        $buyer['phone'] = $request->input('buyer.phone');
        $buyer['birth'] = $request->input('buyer.birth');
        Buyer::updateOrCreate(['user_id'=>$user->id], $buyer);

        return response()->json($user);
    }

    public function passwordPost(Request $request)
    {
        $user = \Auth::user();
        $user = User::find($user->id);

        if (empty($user->password)) {
            return $this->savePasswordIfConfirm($request, $user);
        }

        if (\Auth::attempt(['email' => $user->email, 'password' => $request->input('password')])) {
            return $this->savePasswordIfConfirm($request, $user);
        }

        return response()->json(['status'=>'ok', 'msg'=>'As senhas não conferem']);
    }

    public function avatarPost(Request $request)
    {
        $id = \Auth::user()->id;
        $user = User::findOrFail($id);
        $user->avatar = $request->all()['avatar'];
        $user->save();
        return response()->json(['status'=>'ok']);
    }

    public function addresses()
    {
        return view('me.enderecos');
    }

    public function getAddressesByUserId()
    {
        $user_id = Auth::user()->id;

        // dd(Auth::id());

        $result = Address::where('user_id', $user_id)->get();

        return response()->json($result);

    }

    public function destroyAddress(Request $request, $id)
    {
        $address = Address::find($id);
        if($address->default == true) {
            $first = $request->user()->addresses()->first();
            $first->update(['default' => true]);
        }
        $address->delete();
        return response(null, 204);
    }

    public function addressesPost(Request $request)
    {
        $payload = $request->all();
        $addresses = $request->user()->addresses();
        // Todo: get long and lat
        if($addresses->where('default', true)->first()){
            $payload['default'] = false;
        }
        $save = $request->user()->addresses()->create($payload);

        // if ($save) {
        //     flash('<i class="fa fa-check"></i> Endereço adicionado com sucesso!')->success();
        // } else {
        //     flash('<i class="fa fa-exclamation-triangle"></i> Endereço adicionado com sucesso!')->success();
        // }

        return response()->json($save);
    }

    public function updateAddrDefault(Request $request, $id)
    {
        $addresses = $request->user()->addresses();

        //
        $addresses->update(['default' => false]);

        $current = $addresses->find($id);
        if(!$current) {
            return response()->json(['error' => 'Endereço não existe'], 412);
        }
        $current->update(['default' => $request->status]);

        return response(null, 204);
    }



    public function score()
    {
        return 'Exibição de avaliação do usuário';
    }

    private function savePasswordIfConfirm(Request $request, $user)
    {
        if ($request->input('new_password') === $request->input('confirm_password')) {
            $user->password = bcrypt($request->input('new_password'));
            $user->save();

        return response()->json($user);
        }
        return response()->json(['status'=>'ok', 'msg'=>'As senhas não conferem']);
    }
}
