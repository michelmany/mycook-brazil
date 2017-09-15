<?php

namespace App\Http\Controllers\Moip;

use App\Http\Controllers\Controller;
use Moip\Moip;
use Moip\Resource\Customer;

class MoipOrderController extends Controller
{
    /**
     * @var Moip
     */
    private $moip;

    /**
     * MoipCustomerController constructor.
     */
    public function __construct()
    {
        $this->moip = \Moip::start();
    }

    /**
     * Criar pedido
     *
     */
    public function store()
    {
        $sellerMoipAccountId2 = 'MPA-02E511AFA808'; // alfredo
        $buyerMoipAccountId = 'CUS-LXRSWKPGFXS3'; // cesar

        $customer = $this->moip->customers()->get($buyerMoipAccountId);
//
        try{
            $order = $this->moip->orders()->setOwnId(uniqid())
                ->addItem("Refeição Executiva", 1, "detalhes", 1800) // 35,00
                ->setCustomer($customer)
                ->addReceiver($sellerMoipAccountId2, 'SECONDARY', 1800)
                ->create();

                dd($order);
        }catch (\Exception $e) {
            dump($e->__toString());
        }
    }
}
