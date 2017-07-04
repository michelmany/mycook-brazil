<?php

namespace App\Http\Controllers;

use App\Mail\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Address;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    public function index()
    {
        return view('list.index');

        //To do: 
        // Listar os Chefs via axios para a routa que está pronta: /get-chefs
    }

    public function listChefs()
    {
        $radius = 5;
        $earth_radius = 6371;

        $user_id = \Auth::id();
        $address = Address::where('user_id', $user_id)->orderBy('id', 'desc')->first();

        // dd($address);

        if ($address->latitude && $address->latitude) {

            // Get all chefs 
            $result = DB::table('addresses')
                ->select(DB::raw('user_id, addresses.name, avatar,
                    ( '.$earth_radius.' * acos( cos( radians('.$address->latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude )
                        - radians('.$address->longitude.') )
                        + sin( radians('.$address->latitude.') )
                        * sin(radians(latitude)) ) )
                        AS distance
                    '))
                ->where('role', '=', 'vendedor')
                ->where('active', '=', 1)
                ->having('distance', '<=', $radius)
                ->join('users', 'addresses.user_id', '=', 'users.id')
                ->orderBy('distance', 'desc')
                ->get();
            } else {
                return "O seu endereço cadastro parece estar incorreto. Por favor altere seu endereço principal!";
            }

            //Todo:
            // Listar também caso o user não esteja logado. Pegar pelo CEP.
            // Ao clicar no endereço listado, salvar automaticamente como favorito. E listar sempre bt favorite.

            return response()->json($result);
    }

    public function contatoPost(Request $request)
    {
        $this->validate($request, [
            'sender_name' => 'required|max:255',
            'sender_mail' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $subject = $request->input('subject');
        $sender_mail = $request->input('sender_mail');
        $sender_name = $request->input('sender_name');
        $message = $request->input('message');

        Mail::to(config('mail.contact'))->send(new ContactForm($subject, $sender_mail, $sender_name, $message));
        return redirect()->route('contatoPost')->with('success', 'Sua mensagem foi enviada com sucesso!');
    }

    public function messages()
    {
        return [
            'sender_name.required' => 'A title is required'
        ];
    }

}
