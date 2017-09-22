<?php

namespace App\Http\Controllers\Moip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;

class CartController extends Controller
{

    const CACHE_NAME = 'my-cart';


    private $expiresIn;

    private $request;

    public function __construct(Request $request)
    {
        $this->expiresIn = \Carbon\Carbon::now()->addMinutes(10);
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

    public function addItemToCart()
    {
        // Verifica se existe carrinho, caso não exista inicia um novo
        if(!Cache::has($this->getCartBySeller())) {
            Cache::put($this->getCartBySeller(), [
              'items' => collect([])->push($this->request->item),
              'courier' => $this->request->courier
            ], $this->expiresIn);
            return;
        }

        // caso exista apenas adicionar aos produtos
        $myCart = Cache::get($this->getCartBySeller());

        // adiciona produto ao carrinho
        $myCart['items']->push($this->request->item);

        // remove carrinho atual
        Cache::forget($this->getCartBySeller());

        // adiciona carrinho atualizado
        Cache::put($this->getCartBySeller(), $myCart, $this->expiresIn);
    }


    public function update($index)
    {
      // Obtem carrinho atual
      $myCart = Cache::get($this->getCartBySeller());
      // atualiza item pelo indice
      $myCart['items'][$index] = $this->request->item;

      // remove carrinho atual
      Cache::forget($this->getCartBySeller());

      // adiciona carrinho atualizado
      Cache::put($this->getCartBySeller(), $myCart, $this->expiresIn);
    }
}
