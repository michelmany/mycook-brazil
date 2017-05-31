<?php


namespace App\Http\Controllers;

use App\Buyer;
use App\User;
use Illuminate\Http\Request;

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
        $user = \Auth::user();
        $user = User::find($user->id);

        $user->name = $request->input('user.name');
        $user->email = $request->input('user.email');
        $user->cpf = $request->input('user.cpf');
        $user->save();

        $buyer = $request->input('buyer');
        $buyer['phone'] = implode($buyer['phone']);
        Buyer::firstOrCreate(['user_id'=>$user->id], $buyer);

        return redirect()
            ->route('profile')
            ->with('success', 'Atualizado com sucesso');
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

        return redirect()
            ->route('profile')
            ->with('error', 'A senha não confere');
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

    public function addressesPost()
    {
        return 'Salvando formulário de edição de endereço do usuário logado';
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

            return redirect()
                ->route('profile')
                ->with('success', 'Atualizado com sucesso');
        }
        return redirect()
            ->route('profile')
            ->with('error', 'As senhas não conferem');
    }
}