<?php

namespace App\Http\Controllers\Moip;

use App\Services\Moip\Customer\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerOrderController extends Controller
{
    /**
     * @var OrderService
     */
    private $service;

    /**
     * CustomerOrderController constructor.
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * View orders lists
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('me.orders');
    }

    /**
     * View get order
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $order = $this->service->find($id);

        return view('me.show_order', compact('order'));
    }

    /**
     * List all orders by email user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function allOrders(Request $request)
    {
        return $this->service->all(10, $request->page);
    }
}
