<?php

namespace App\Http\Controllers\Moip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;

class CartController extends Controller
{
    
    const CACHE_NAME = 'my-cart';

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return string
     */
    private function getCartBySeller()
    {
        return str_finish(self::CACHE_NAME, str_replace('/', '-', $this->request->seller));
    }

    /**
    *
    */
    public function index() 
    {
        if(!Cache::has($this->getCartBySeller())) {
            return response(null, 204);
        }

        return Cache::get($this->getCartBySeller());
    }


    public function store()
    {
        $expiresIn = \Carbon\Carbon::now()->addMinutes(5);

        if(!Cache::has($this->getCartBySeller())) {
            $cart = [
                'items' => collect([])->merge($this->request->items),
                'courier' => $this->request->courier
            ];

            Cache::put($this->getCartBySeller(), $cart, $expiresIn);
            return;
        }
        
        $cart = Cache::get($this->getCartBySeller());
        
        // remove cart
        Cache::forget($this->getCartBySeller());
          
        $item = $this->request->items;

        if($item['qty'] !== 0) {
            if(isset($cart['items']->toArray()[$this->request->index])) {
                $cart['items']->splice($this->request->index, 1);
                $cart['items']->push($this->request->items);
            }
            Cache::put($this->getCartBySeller(), $cart, $expiresIn);
            return;
        }

        //remover item
        $cart['items']->splice($this->request->index, 1);

        if(count($cart['items']) > 0){
            Cache::put($this->getCartBySeller(), $cart, $expiresIn);
            return;
        }

        // se não existir mais produtos, remover cache
        Cache::forget($this->getCartBySeller());

    }



}
