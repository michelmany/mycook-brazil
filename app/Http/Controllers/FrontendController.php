<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Requests;
use App\Mail\ContactForm;
use App\Models\Moip\MoipSeller;
use App\Product;
use App\ProductExtra;
use App\Seller;
use App\Space\CalculateDistance;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    private $radius = 5;
    private $earth_radius = 6371;
    private $address_lat;
    private $address_lng;
    private $result;
    private $day;

    public function index($latitude = '', $longitude = '')
    {
        // dd($cep);
        if (!empty($latitude) && !empty($longitude)) {
            return view('list.index', ['latitude' => $latitude, 'longitude' => $longitude]);
        } else {
            return view('list.index');
        }
    }

    // When logged and have address
    public function listChefs()
    {
        if ( Auth::check() ) {
            $user_id = \Auth::id();
            $address = Address::where('user_id', $user_id)->orderBy('id', 'desc')->first();
            $this->address_lat = $address->latitude;
            $this->address_lng = $address->longitude;

            if ($address) {
                $this->getChefsByDistance();
            } else {
                return response()->route('home');
            }

        } else {
            return redirect()->route('entrar');
        }

        //Todo:
        // Ao clicar no endereço listado, salvar automaticamente como favorito. E listar sempre bt favorite.

        return response()->json($this->result);
    }

    public function listChefsByCep(Request $request)
    {
        $this->address_lat = $request->latitude;
        $this->address_lng = $request->longitude;
        $this->getChefsByDistance();
        return response()->json($this->result);
    }

    public function singleChef($id, $city = '', $slug = '')
    {
        $seller = User::findOrFail($id);
        $addressSeller = Address::where('user_id', $id)->orderBy('id', 'desc')->first();

        //moipseller - by César
        $moipSeller = MoipSeller::select('moipAccount as moipId')->where('user_id', $id)->first();

        if ( Auth::check() ) {
            $user_id = Auth::id();
            $addressUser = Address::where('user_id', $user_id)->orderBy('id', 'desc')->first();

            $userLocal = new CalculateDistance($addressSeller->latitude, $addressSeller->longitude, 
                        $addressUser->latitude, $addressUser->longitude, "K");
            $seller->distance = round($userLocal->distance(), 2);
        } 

        if ($slug !== $seller->slug) {
            return redirect()->to($seller->url);
        }

        if ($seller->role == 'vendedor') {
            return view('list.single-chef')
                        ->with('moipseller', $moipSeller)
                        ->withSeller($seller, $seller->seller);
        } else {
            return redirect()->route('lista-chefs-page');
        }
    }

    public function listProducts($id, $day = null)
    {
        if(empty($day)) {
            $products = Product::where('seller_id', $id)->with('extras')->orderBy('id', 'asc')->get();
        } else {
            $this->day = $day;

            $products = Product::where('seller_id', $id)
                        ->join('product_extras', function ($join) {
                            $join->on('products.id', '=', 'product_extras.product_id')
                                 ->where('product_extras.date', '=', $this->day)
                                 ->where('product_extras.quantity', '>', 0);
                        })->get();
        }

        return response()->json($products);
    }
    // public function listFilteredProducts($id)
    // {

    //     $products = Product::where('seller_id', $id)->with('extras')->orderBy('id', 'asc')->get();

    //     return response()->json($products);
    // }

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

    private function getChefsByDistance()
    {
        // Get all chefs 
        $this->result = DB::table('addresses')
            ->select(DB::raw('user_id, users.name, users.avatar,
                ( '.$this->earth_radius.' * acos( cos( radians('.$this->address_lat.') ) * cos( radians( latitude ) ) * cos( radians( longitude )
                    - radians('.$this->address_lng.') )
                    + sin( radians('.$this->address_lat.') )
                    * sin(radians(latitude)) ) )
                    AS distance
                '))
            ->where('role', '=', 'vendedor')
            ->where('active', '=', 1)
            ->having('distance', '<=', $this->radius)
            ->join('users', 'addresses.user_id', '=', 'users.id')
            ->orderBy('distance', 'asc')
            ->get();

            // Get avatar
            foreach ($this->result as $chef) {
                if (empty($chef->avatar)) {
                    $chef->avatar = url('assets/img/no-image_01.jpg');
                } else {
                    $chef->avatar = \Storage::cloud()->url('avatar/' . $chef->avatar);
                }
            }

    }

}
