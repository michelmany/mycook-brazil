<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Requests;
use App\Mail\ContactForm;
use App\Product;
use App\ProductExtra;
use App\Seller;
use App\Space\CalculateDistance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    public function index()
    {
        return view('list.index');

    }

    public function listChefs()
    {
        $radius = 5;
        $earth_radius = 6371;

        $user_id = \Auth::id();
        $address = Address::where('user_id', $user_id)->orderBy('id', 'desc')->first();

        if ($address) {

            // Get all chefs 
            $result = DB::table('addresses')
                ->select(DB::raw('user_id, users.name, users.avatar,
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
                ->orderBy('distance', 'asc')
                ->get();
            } else {
                return "O seu endereço cadastro parece estar incorreto. Por favor altere seu endereço principal!";

                //Todo: Create functionality to get the chefs by a CEP even not logged in
            }

            $avatar_url = \Storage::cloud()->url('filename');

            foreach ($result as $chef) {
                $chef->avatar = $avatar_url = \Storage::cloud()->url('avatar/' . $chef->avatar);
            }

            //Todo:
            // Listar também caso o user não esteja logado. Pegar pelo CEP.
            // Ao clicar no endereço listado, salvar automaticamente como favorito. E listar sempre bt favorite.

            return response()->json($result);
    }

    public function singleChef($id, $city = '', $slug = '')
    {
        $user_id = \Auth::id();
        $addressUser = Address::where('user_id', $user_id)->orderBy('id', 'desc')->first();

        $seller = User::findOrFail($id);
        $addressSeller = Address::where('user_id', $id)->orderBy('id', 'desc')->first();

        $userLocal = new CalculateDistance($addressSeller->latitude, $addressSeller->longitude, 
                    $addressUser->latitude, $addressUser->longitude, "K");
        $seller->distance = round($userLocal->distance(), 2);


        if ($slug !== $seller->slug) {
            return redirect()->to($seller->url);
        }

        if ($seller->role == 'vendedor') {
            return view('list.single-chef')
                ->withSeller($seller, $seller->seller);
        } else {
            return redirect()->route('lista-chefs-page');
        }
    }

    public function listProducts($id)
    {

        $products = Product::where('seller_id', $id)->with('extras')->orderBy('id', 'asc')->get();

        return response()->json($products);
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
