<?php

namespace App\Services\Moip;

use App\Models\OrderDeliveryData;
use Illuminate\Http\Request;
use App\User;
use App\Models\Buyer;
use App\Models\Address;
use Moip\Helper\Utils;
use Moip\Resource\Customer;
use Exception;
use App\Models\Product;

class CheckoutService
{
    /**
     * @var \Moip\Moip
     */
    private $moip;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Buyer
     */
    private $buyer;

    /**
    * @var
    */
    private $address;

    /**
     * @var Request
     */
    private $request;

    /**
     * MoipCheckoutService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->moip = \Moip::start();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function process(Request $request)
    {
        $this->request = $request;
        $this->user  = $request->user();
        $this->buyer = $this->user->buyer;
        $this->address = $this->user->addresses;

        // check
        $this->verifyBuyerProfile();

        $this->verifyAddress();

        return $this->createCustomer();
    }

    /**
     * Get customer by id
     *
     * @param $customerId
     * @return \Illuminate\Http\JsonResponse|Customer|\stdClass
     */
    public function getCustomer($customerId)
    {
        try{
            $customer = $this->moip->customers()->get($customerId);
            return $customer;
        }catch (Exception $e) {
            return response()->json(['error' => 'Cliente não encontrado', '__toString' => $e->__toString()], 401);
        }
    }

    /**
     * Create customer of order
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCustomer()
    {
        $phone = explode(' ', $this->buyer->phone);

        if(!$this->buyer->moipAccount) {
            try{
                /** @var Customer $customer */
                $customer = $this->moip->customers()->setOwnId(uniqid())
                    ->setFullname($this->user->name)
                    ->setEmail($this->user->email)
                    ->setTaxDocument($this->user->cpf)
                    ->setPhone($phone[0], $phone[1])
                    ->addAddress('SHIPPING',
                        $this->address[0]->address,
                        $this->address[0]->number,
                        $this->address[0]->neighborhood,
                        $this->address[0]->city,
                        $this->address[0]->state,
                        $this->address[0]->cep)
                    ->create();

                $this->buyer->update(['moipAccount' => $customer->getId()]);

                return $this->createOrder($customer);

            }catch (Exception $e) {
                return response()->json([ 'error' => 'Houve um erro no processo de criação do cliente', '__toString' => $e->__toString()], 400);
            }
        }

        return $this->createOrder($this->getCustomer($this->buyer->moipAccount));
    }

    /**
     *  Create order and return request
     * @param Customer $customer
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOrder(Customer $customer)
    {
        try{
            $order = $this->moip->orders()->setOwnId(uniqid());
            if(count($this->request->items) <= 0){
                return response()->json(['error' => 'Não existem produtos no carrinho.'], 422);
            }

            foreach ($this->request->items as $item) {
                $this->checkItem($item);
                $order->addItem($item['name'], $item['qty'], $item['desc'], Utils::toCents((float)$item['price']));
            }
            // redirect
            $order->setUrlSuccess(route('moip.payments.success'))
                  ->setUrlFailure(route('moip.payments.error'));
            $order
                  ->setCustomer($customer)
                  ->addReceiver($this->request->seller, 'SECONDARY', Utils::toCents((float)$this->request->total), null, true)
                  ->create();

            // Register Courier Address
            OrderDeliveryData::create([
                'orderId' => $order->jsonSerialize()->id,
                'day' => $this->request->courier['date'],
                'fulldate' => $this->request->courier['fulldate'],
                'time' => $this->request->courier['time'],
            ]);

            // Clean cart
            \Cache::forget('my-cart');

            return response()->json($order, 201);
        }catch (\Exception $e) {
            return response()->json(['error' => 'Pedido falhou, atualize a página e tente novamente', '__toString'=>$e->__toString()], 400);
        }
    }

    /**
     * Check if buyer has required data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function verifyBuyerProfile()
    {
        if(!$this->buyer) {
            return response()->json([
                'error' => 'Sua conta não possui um perfil de comprador',
                '_link' => '/minha-conta/perfil'
            ],412);
        }

        if(!$this->user->cpf) {
            return response()->json([
                'error' => 'Infome o seu número de CPF',
                '_link' => '/minha-conta/perfil'
            ],412);
        }

        if(!$this->buyer->phone) {
            return response()->json([
                'error' => 'Informe seu Celular ou Telefone',
                '_link' => '/minha-conta/perfil'
            ],412);
        }

    }

    /**
     * Address validation
     *
     */
    private function verifyAddress()
    {
        if(!$this->address) {
            return response()->json([
                'error' => 'É necessário cadastrar um endereço.',
                '_link' => '/minha-conta/enderecos'
            ], 412);
        }
    }

    /**
     * Verify product
     *
     * @param $item
     * @return \Illuminate\Http\JsonResponse
     */
    private function checkItem($item)
    {
        $product = Product::find($item['id']);

        if(!$product) {
            return response()->json([
                'error' => 'Este produto não existe!',
            ], 412);
        }

        if($item['price'] !== $product['price']) {
            return response()->json([
                'error' => 'Preço do produto não corresponde ao esperado.',
            ], 412);
        }
    }
}
