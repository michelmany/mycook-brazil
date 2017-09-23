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
        $cart = Cache::get($this->getCartBySeller());
        $cart['items'] = $cart['items']->map(function($item, $index) {
            $item['extras'] = \App\Models\ProductExtra::where('product_id', $item['id'])->get();
            return $item;
        })->all();

        return $cart;
    }

    public function addItemToCart()
    {
        // Verifica se existe carrinho, caso não exista inicia um novo
        if(!Cache::has($this->getCartBySeller())) {
            Cache::put($this->getCartBySeller(), [
              'items' => collect([])->push($this->request->item),
              'courier' => $this->request->courier,
              'selectedDateIndex' => $this->request->selectedDateIndex,
              'selectedTimes' => $this->request->selectedTimes
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
      if($this->request->item['qty'] === 0) {
          $myCart['items']->splice($index,  1);
      }else{
        // atualiza item pelo indice
        $myCart['items'][$index] = $this->request->item;
      }

      // remove carrinho atual
      Cache::forget($this->getCartBySeller());

      // caso o carrinho possua items
      if($myCart['items']->isNotEmpty()) {
        // adiciona carrinho atualizado
        Cache::put($this->getCartBySeller(), $myCart, $this->expiresIn);
      }
    }
}
