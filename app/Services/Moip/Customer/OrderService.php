<?php

namespace App\Services\Moip\Customer;

use App\Models\OrderDeliveryData;
use App\Support\Moip\Utils;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Moip\Helper\Pagination;
use Moip\Moip;


class OrderService
{
    /**
     * @var Moip
     */
    private $moip;

    /**
     * @var Request
     */
    private $request;

    /**
     * OrderService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->moip = \Moip::start();
        $this->request = $request;
    }

    /**
     * List all orders by user
     *
     * @param int $total
     * @param int $page
     * @return mixed
     */
    public function all($total = 5, $page = 1)
    {
        $offset = ($total * $page) - $total;
        $pagination = new Pagination($total, $offset);

        $customerOrders = $this->moip->orders()->getList($pagination, null, $this->request->user()->email);

        $orders = [];

        if(count($customerOrders->getOrders()) > 0) {
            foreach($customerOrders->getOrders() as $k => $order) {

                $payment = $order->payments[0];

                $orders['orders'][$k] = [
                    'code' => $order->ownId,
                    'id' => $order->id,
                    'status' => $order->status  === 'PAID' ? 'Pago' : 'Aguardando',
                    'payment' => [
                        'type' => $payment->fundingInstrument->method,
                        'brand' => $payment->fundingInstrument->brand
                    ],
                    'amount' => Utils::formatAmount($order->amount->total),
                    'timestamps' => [
                        'created_at' => Utils::formatDate($order->createdAt)->format('d-m-Y H:i:s'),
                        'updated_at' => Utils::formatDate($order->updatedAt)->diffForHumans()
                    ],
                ];
            }

            $summary = $customerOrders->jsonSerialize()->summary;

            $orders['meta'] = [
                'total' => $summary->count,
                'pages' => (int)ceil($summary->count/$total),
                'amount' => Utils::formatAmount($summary->amount)
            ];

        }

        return $orders;
    }

    /**
     * Show ordem by code
     */
    public function find($orderId)
    {
        try{
            $search = $this->moip->orders()->get($orderId);
            $order = $search->jsonSerialize();
            $payments = $order->payments[0]->jsonSerialize();

            $seller = collect($order->receivers)->filter(function($seller) {
                return $seller->type === 'SECONDARY';
            })->first();

            if(!isset($seller)) {
                $seller = $order->receivers[0];
            }

            $chef = User::where('email', $seller->moipAccount->login)->first();
        
            return (object)[
                'id' => $order->id,
                'ownId' => $order->ownId,
                'status' => (object)[
                    'formatted' => Utils::formatOrderStatus($order->status),
                    'origin' => $order->status
                ],
                'items' => $this->getItemsAndFormat($order->items),
                'payment' => (object)[
                    'id' => $payments->id,
                    'detail' => $this->getPaymentMethodandFormat($payments),
                    'status' => (object)[
                        'formatted' => Utils::formatPaymentStatus($payments->status),
                        'origin' => $payments->status
                    ],
                    'amount' => Utils::formatAmount($payments->amount->total),
                    'timestamps' => (object)[
                        'created_at' => $payments->createdAt->format('d-m-Y H:i:s'),
                        'updated_at' => Utils::formatDate($payments->updatedAt->getTimestamp())->diffForHumans()
                    ]
                ],
                'chef' => (object)[
                    'name' => $chef->name,
                    'email' => $chef->email,
                    'avatar' => $chef->avatar
                ],
                'courier' => OrderDeliveryData::where('orderId', $orderId)->first(),
                '_links' => (object)[
                    'order' => $order->_links->self->href,
                    'checkout' => $order->_links->checkout->payCheckout->redirectHref,
                ]
            ];

        }catch (\Exception $e) {
            return response()->json(['error' => $e->__toString()]);
        }
    }


    /**
     * @param $payment
     * @return object
     */
    private function getPaymentMethodandFormat($payment) {

        if($payment->fundingInstrument->method === 'BOLETO') {
            $boleto = $payment->fundingInstrument->boleto;
            return (object)[
                'expiration' => $boleto->expirationDate,
                'line_code' => $boleto->lineCode,
                'type' => 'BOLETO'
            ];
        }

        if($payment->fundingInstrument->method === 'CREDIT_CARD') {
            $creditCard = $payment->fundingInstrument->creditCard;
            return (object)[
                'brand' => $creditCard->brand,
                'last' => $creditCard->last4,
                'type' => 'CREDIT_CARD'
            ];
        }

        if($payment->fundingInstrument->method === 'ONLINE_BANK_DEBIT') {
            $bank = $payment->fundingInstrument->onlineBankDebit;
            return (object) [
                'name' => $bank->bankName,
                'expiration' => date("d/m/Y", strtotime($bank->expirationDate)),
                'type' => 'ONLINE_BANK_DEBIT'
            ];
        }
    }

    /**
     * @param $items
     * @return array
     */
    private function getItemsAndFormat($items) {
        return collect($items)->map(function($item) {
            return (object)[
                'name'  => $item->product,
                'price' => Utils::formatAmount($item->price),
                'detail'=> $item->detail,
                'qty'   => $item->quantity
            ];
        })->all();
    }
}