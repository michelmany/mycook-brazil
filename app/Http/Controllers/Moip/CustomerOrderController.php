<?php

namespace App\Http\Controllers\Moip;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Moip\Moip;
use Moip\Helper\Pagination;

class CustomerOrderController extends Controller
{
    /**
    * @var Moip
    */
    private $moip;

    public function __construct()
    {
        $this->middleware('auth');
        $this->moip = \Moip::start();
    }

    /**
     * List all orders by email user
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $pagination = new Pagination(5, 0);

        $customerOrders = $this->moip->orders()->getList($pagination, null, $request->user()->email);
        
        $orders = [];

        foreach($customerOrders->getOrders() as $k => $order) {

            $payment = $order->payments[0];

            $orders[$k] = [
                'code' => $order->ownId,
                'id' => $order->id,
                'status' => $order->status  === 'PAID' ? 'Pago' : 'Aguardando',
                'payment' => [
                    'type' => $payment->fundingInstrument->method,
                    'brand' => $payment->fundingInstrument->brand
                ],
                'amount' => number_format(
                    (float)chunk_split($order->amount->total, strlen($order->amount->total)-2, '.'),
                    2,
                    ',',
                    '.'
                ),
                'timestamps' => [
                    'created_at' => $order->createdAt,
                    'updated_at' => $order->updatedAt
                ],
            ];
        }

        return response()->json($orders);
    }
}
