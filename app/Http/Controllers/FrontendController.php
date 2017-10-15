<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests;
use App\Mail\ContactForm;
use App\Models\Moip\MoipSeller;
use App\Models\Product;
use App\Models\ProductExtra;
use App\Models\Seller;
use App\Services\System\SettingService;
use App\Support\CalculateDistance;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class FrontendController extends Controller
{
    /** @var  SettingService */
    private $serviceSetting;

    private $radius = 5;
    private $earth_radius = 6371;
    private $address_lat;
    private $address_lng;
    private $result;
    private $day;

    /**
     * FrontendController constructor.
     * @param SettingService $serviceSetting
     */
    public function __construct(SettingService $serviceSetting)
    {
        $this->serviceSetting = $serviceSetting;
    }


    /**
     * @param string $latitude
     * @param string $longitude
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($latitude = '', $longitude = '')
    {
        if (!empty($latitude) && !empty($longitude)) {
            return view('list.index', ['latitude' => $latitude, 'longitude' => $longitude]);
        } else {
            return view('list.index');
        }
    }

    /**
     * When logged and have address
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function listChefs()
    {
        if ( Auth::check() ) {
            $address = auth()->user()->addresses()->orderBy('id', 'desc')->first();
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function listChefsByCep(Request $request)
    {
        $this->address_lat = $request->latitude;
        $this->address_lng = $request->longitude;
        $this->getChefsByDistance();
        return response()->json($this->result);
    }

    /**
     * @param $id
     * @param string $city
     * @param string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function singleChef(Request $request, $id, $city = '', $slug = '')
    {
        $seller = User::findOrFail($id);
        $addressSeller = Address::where('user_id', $id)->orderBy('id', 'desc')->first();

        //moipseller - by César
        $moipSeller = MoipSeller::select('moipAccount as moipId')->where('user_id', $id)->first();

        $settings = $this->serviceSetting->all();

        if(!$moipSeller) {
            return redirect()->back()->with('fail', "O Chefe {$seller->name} não está com os dados configurados corretamente.");
        }

        if ( Auth::check() ) {
            $addressUser = $request->user()->addresses()->orderBy('id', 'desc')->first();
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
                        ->with('settings', $settings)
                        ->withSeller($seller, $seller->seller);
        }
        return redirect()->route('lista-chefs-page');
    }

    /**
     * @param $id
     * @param null $day
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'sender_name.required' => 'A title is required'
        ];
    }

    /**
     *
     */
    private function getChefsByDistance()
    {
        // Get all chefs
        $this->result = DB::table('addresses')
            ->select(DB::raw("
                addresses.user_id, 
                users.name, (sellers.data->>'$.avatar') AS logo, 
                (sellers.data->>'$.title') AS custom_name, 
                (sellers.data->>'$.description') AS description, 
                ( '.$this->earth_radius.' * acos( cos( radians('.$this->address_lat.') ) * cos( radians( latitude ) ) * cos( radians( longitude )
                    - radians('.$this->address_lng.') )
                    + sin( radians('.$this->address_lat.') )
                    * sin(radians(latitude)) ) )
                    AS distance
                "))
            ->where('role', '=', 'vendedor')
            ->where('users.id', "!=", auth()->check() ? auth()->user()->id : null) // evitar que vendedor compre em sua próprio "loja"
            ->where('active', '=', 1)
            ->having('distance', '<=', $this->serviceSetting->get('radius') ?? $this->radius)
            ->join('users', 'addresses.user_id', '=', 'users.id')
            ->join('sellers', 'addresses.user_id', '=', 'sellers.user_id')
            ->orderBy('distance', 'asc')
            ->get();



            // Get avatar
            foreach ($this->result as $k => $chef) {
                $moip = \App\Models\Moip\MoipSeller::select('moipAccount as id')->whereUserId($chef->user_id)->first();

                if(!$moip) {
                    unset($this->result[$k]);
                }

                if (empty($chef->logo)) {
                    $chef->logo = url('assets/img/no-image_01.jpg');
                }
            }

    }

}
