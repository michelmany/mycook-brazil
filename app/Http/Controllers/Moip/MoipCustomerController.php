<?php

namespace App\Http\Controllers\Moip;

use App\Buyer;
use App\User;
use Artesaos\Moip\Moip;
use Exception;
use App\Http\Controllers\Controller;
use Moip\Resource\Customer;

class MoipCustomerController extends Controller
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
     * Consultar cliente pelo código
     * @param $id
     * @return string
     */
    public function show($id)
    {
        $buyer= Buyer::where('moipAccount', '=', $id)->first();

        try{
            $customer_id = $buyer->moipAccount;
            $customer = $this->moip->customers()->get($customer_id);
            dd($customer);
        }catch (Exception $e) {
            return($e->__toString());
        }
    }

    /**
     * Registra cliente
     */
    public function store()
    {
        /** @var User $user */
        $user = \request()->user();
        $buyer = $user->buyer;
        $address = $user->addresses()->first();
        $phone = explode(' ', $user->buyer->phone);

        if(!$buyer->moipAccount) {
            try{
                /** @var Customer $customer */
                $customer = $this->moip->customers()->setOwnId(uniqid())
                    ->setFullname($user->name)
                    ->setEmail($user->email)
                    ->setTaxDocument($user->cpf)
                    ->setPhone($phone[0], $phone[1])
                    ->addAddress('SHIPPING', $address->address, $address->number, $address->neighborhood, $address->city, $address->state, $address->cep)
                    ->create();
                $user->buyer()->update(['moipAccount' => $customer->getId()]);
                return response($customer, 201);
            }catch (Exception $e) {
                dd($e->__toString());
            }
        }
    }
}
