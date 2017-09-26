<?php

namespace App\Services\Moip\Customer;

use App\Models\Order;
use App\Support\Moip\Utils;
use Illuminate\Http\Request;
use Moip\Moip;
use Moip\Resource\Orders;


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
     * Order
     */
    public function find($orderId)
    {
        $order = $this->syncOrderIdMoip($orderId);

        return $order;
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
        $orders = $this->request->user()->buyer->orders;
        $orders = $orders->map(function($order) {
            $order['status'] = Utils::formatOrderStatus($order['status']);
            $order->amount['total'] = 10;
            return $order;
        })->all();

        return compact('orders');
    }

    /**
     * Show order by code
     *
     * @param $orderId
     * @return mixed
     */
    public function findMoip($orderId)
    {
        try{
            /** @var Orders $order */
            $order = $this->moip->orders()->get($orderId);
            return $order;
        }catch (\Exception $e) {
            return response()->json(['error' => $e->__toString()]);
        }
    }

    /**
     * Format order
     *
     * @param $orderId
     * @return object
     */
    public function formatOrderById($orderId)
    {
        $search = $this->findMoip($orderId);
        $order = $search->jsonSerialize();

        $orderFormatted = [
            'id' => $order->id,
            'ownId' => $order->ownId,
            'status' => (object)[
                'formatted' => Utils::formatOrderStatus($order->status),
                'origin' => $order->status
            ],
            'items' => $this->getItemsAndFormat($order->items)
        ];

        if(isset($order->payments[0])) {

            $payments = $order->payments[0]->jsonSerialize();

            $orderFormatted['payment'] = (object)[
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
            ];
        }

        return (object)$orderFormatted;
    }

    /**
     * Sync order
     *
     * @param $orderId
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function syncOrderIdMoip($orderId)
    {
        $order = $this->formatOrderById($orderId);

        $update = Order::where('orderId', $order->id)->first();
        $update->status = $order->status->origin;
        $update->payment = $order->payment ?? null;
        $update->save();

        return $update;
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
