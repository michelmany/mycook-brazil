<?php

namespace App\Http\Controllers\Moip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;

class CartController extends Controller
{

    const CACHE_NAME = 'my-cart';

    /** @var static  */
    private $expiresIn;

    /** @var Request  */
    private $request;

    /**
     * CartController constructor.
     * @param Request $request
     */
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
    private function getAddressBySeller()
    {
        return str_finish('address', str_replace('/', '-', $this->request->seller));
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

    /**
     *  Adiciona item ao carrinho
     */
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

        // remove carrinho atual
        Cache::forget($this->getCartBySeller());

        $myCart['items']->each(function ($product, $index) use ($myCart){
            if($product['id'] !== $this->request->item['id']) {
                $myCart['items']->push($this->request->item);
            }
            return $myCart;
        });

        // adiciona carrinho atualizado
        Cache::put($this->getCartBySeller(), $myCart, $this->expiresIn);
    }

    /**
     * Adicionar endereço
     */
    public function addAddress()
    {
        if(Cache::has($this->getAddressBySeller())) {
           Cache::forget($this->getAddressBySeller());
        }

        Cache::put($this->getAddressBySeller(), $this->request->get('address'), $this->expiresIn);
    }

    /**
     * Obtem endereço
     *
     * @return mixed
     */
    public function getAddress()
    {
        if(Cache::has($this->getAddressBySeller())) {
            return response()->json(Cache::get($this->getAddressBySeller()));
        }

        return response(null, 204);
    }



    /**
     * @param $index
     */
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
