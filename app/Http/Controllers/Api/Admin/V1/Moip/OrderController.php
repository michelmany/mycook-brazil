<?php

namespace App\Http\Controllers\Api\Admin\V1\Moip;

use App\Models\Order;
use App\Models\Seller;
use App\Services\Moip\Customer\OrderService;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;

class OrderController
{
    /** @var  User */
    private $user;

    /** @var  OrderService */
    private $service;

    public function __construct(Request $request, OrderService $service)
    {
        $this->user = JWTAuth::toUser($request->bearerToken());
        $this->service = $service;
    }

    /**
     * Get all orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

        if($this->user->role === 'vendedor')
        {
            /** @var Seller $seller */
            $orders = $this->user->seller->orders;
        }

        if($this->user->role == 'admin')
        {
            $orders = Order::all();
        }

        return response()->json(compact('orders'));
    }

    /**
     * Get order
     *
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Order $order)
    {
        /** @var Order $order */
        $order = $this->service->syncOrderIdMoip($order->orderId);
        $order->address->address;
        return response()->json(compact('order'));
    }
}