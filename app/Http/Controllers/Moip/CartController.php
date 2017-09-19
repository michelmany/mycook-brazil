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
    *
    */
    public function index() 
    {
        if(!Cache::has(self::CACHE_NAME)) {
            return response(null, 204);
        }

        return Cache::get(self::CACHE_NAME);
    }

    
    public function store()
    {
        $expiresIn = \Carbon\Carbon::now()->addMinutes(30);

        if(!Cache::has(self::CACHE_NAME)) {
            $cart = [
                'items' => collect([])->merge($this->request->items),
                'courier' => $this->request->courier
            ];

            Cache::put(self::CACHE_NAME, $cart, $expiresIn);
            return;
        }
        
        $cart = Cache::get(self::CACHE_NAME);
        
        // remove cart
        Cache::forget(self::CACHE_NAME);
          
        $item = $this->request->items;
        
        if(isset($cart['items']->toArray()[$this->request->index])) {
            $cart['items']->splice($this->request->index, 1);
            $cart['items']->push($this->request->items);
        }
        
        Cache::put(self::CACHE_NAME, $cart, $expiresIn);
    }

}
