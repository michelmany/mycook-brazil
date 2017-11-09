<?php

namespace App\Services\Moip;

use App\Models\Order;
use App\Models\OrderDeliveryData;
use App\Services\System\SettingService;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Models\Buyer;
use App\Models\Address;
use Moip\Helper\Utils;
use Moip\Resource\Customer;
use Exception;
use App\Models\Product;
use App\Support\Moip\Utils as MoipUtil;
use Moip\Resource\Orders;

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
     * @var SettingService
     */
    private $settingService;

    /**
     * MoipCheckoutService constructor.
     * @param Request $request
     * @param SettingService $settingService
     */
    public function __construct(Request $request, SettingService $settingService)
    {
        $this->moip = \Moip::start();
        $this->settingService = $settingService;
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
        $this->address = $this->getAddress();

        $this->verifyBuyerProfile();
        $this->verifyAddress();

        return $this->findOrCreateCustomer();
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
     * Get address defined in cart
     *
     */
    public function getAddress()
    {
        return $this->user->addresses()->where('default', true)->first();
    }

    /**
     * Create customer of order
     * @return \Illuminate\Http\JsonResponse
     */
    public function findOrCreateCustomer()
    {
        $this->verifyAddress();
        
        if(empty($this->buyer->phone) || !isset($this->buyer->phone))  {
            return response()->json([
                'error' => 'Adicione um telefone de contato em seu perfil para prosseguir',
                '_link' => '/minha-conta/perfil'
            ],422);
        }

        $phone_ddd = substr($this->buyer->phone, 0 ,2);
        $phone_number = substr($this->buyer->phone, 2);

        if(!$this->buyer->moipAccount) {
            try{
                /** @var Customer $customer */
                $customer = $this->moip->customers()->setOwnId(uniqid())
                    ->setFullname($this->user->name)
                    ->setEmail($this->user->email)
                    ->setTaxDocument($this->user->cpf)
                    ->setPhone($phone_ddd, $phone_number)
                    ->addAddress('SHIPPING',
                        $this->address->address,
                        $this->address->number,
                        $this->address->neighborhood,
                        $this->address->city,
                        $this->address->state,
                        $this->address->cep)
                    ->create();

                $this->buyer->update(['moipAccount' => $customer->getId()]);

                return $this->createOrder($customer);

            }catch (Exception $e) {
                // dd($e);
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
        /**
         * Todo: valor do frete
         */
        $freteAmount = (float)$this->settingService->get('delivery_fee');

        try{
            $order = $this->moip->orders()->setOwnId(uniqid());

            if(count($this->request->items) <= 0){
                return response()->json(['error' => 'Não existem produtos no carrinho.'], 422);
            }

            foreach ($this->request->items as $item) {
                $this->checkItem($item);
                $order->addItem($item['name'], $item['qty'], $item['desc'], Utils::toCents((float)$item['price']));
            }

            $order->setShippingAmount(Utils::toCents($freteAmount));

            if(isset($this->request->additional[1])) {
                $coupon = $this->request->additional[1];
                $order->setDiscount(Utils::toCents((float)$coupon['price']));
            }

            // redirect
            $order->setUrlSuccess(route('moip.payments.success'))
                  ->setUrlFailure(route('moip.payments.error'));
            $order
                ->setCustomer($customer)
                // Todo: implementações issue [https://mycook.mydonedone.com/issuetracker/projects/64131/issues/8]
                ->addInstallmentCheckoutPreferences([1, 1])
                ->addReceiver($this->request->seller, 'SECONDARY', null, 78, false)
                ->create();

            $this->saveOrder($order);
            $this->clearCartCache();
            return response()->json($order->getLinks()->getCheckout('payCreditCard'), 201);
        }catch (\Exception $e) {
             dd($e);
            return response()->json(['error' => 'Pedido falhou, atualize a página e tente novamente', '__toString'=>$e->__toString()], 400);
        }
    }

    /**
     * Cadastra pedido no banco de dados
     *
     * @param Orders $order
     * @return void
     */
    private function saveOrder(Orders $order)
    {
        /**
         * Todo: simular desconto moip
         */
        $totalAmount = (float)$this->request->total;
        $percentage_rate = config('moip.settings.percentage_rate');
        $additional_rate = config('moip.settings.additional_rate');
        $moipDiscount = ($percentage_rate * $totalAmount) / 100 + $additional_rate;

        $items = [];
        foreach ($order->getItemIterator()->getArrayCopy() as $key => $item) {
            $items[$key] = [
                'product' => $item->product,
                'price' => MoipUtil::formatAmount($item->price),
                'detail' => $item->detail,
                'quantity' => $item->quantity,
                'note'  => $this->request->items[$key]['note'] ?? 'sem observações.'
            ];
        }

        $orders = new Order();
        $orderDeliveryData = new OrderDeliveryData();
        
        try{    
            $orders->orderId = $order->getId();
            $orders->seller_id = $this->request->seller_id;
            $orders->buyer_id = $this->buyer->id;
            $orders->status = $order->getStatus();
            $orders->items = array_merge($items, $this->request->additional, ['moip_rate' => $moipDiscount]);

            $orders->status_delivery = 0;
            $orders->amount = [
                'total' => MoipUtil::formatAmount($order->getAmountTotal()),
            ];
            $orders->_links = array_merge(['order' => $order->getLinks()->getSelf()], ['checkout' => $order->getLinks()->getAllCheckout()]);
            $orders->save();
        }catch (\Error $e) {
            return response()->json(['error' => $e->__toString()], 400);
        }

        try {
            $orderDeliveryData->order()->associate($orders);
            $orderDeliveryData->address_id = $this->address->id;
            $orderDeliveryData->day = MoipUtil::formatDate($this->request->courier['time'])->format('d');
            $orderDeliveryData->fulldate =  $this->request->courier['fulldate'];
            $orderDeliveryData->time = Carbon::parse($this->request->courier['time']);
            $orderDeliveryData->save();
        } catch (Exception $e) {
          $orders->delete();
          $orderDeliveryData->delete();
          return response()->json(['error' => $e->__toString()], 400);
        }

    }

    /**
     * Clear cart
     *
     * @return void
     */
    private function clearCartCache()
    {
        Cache::forget(str_finish('my-cart', str_replace('/', '-', $this->request->pathname)));
        Cache::forget(str_finish('address', str_replace('/', '-', $this->request->pathname)));
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
