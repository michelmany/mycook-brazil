<?php

namespace App\Http\Controllers\Moip;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Moip\CheckoutService;
use App\Services\Moip\Customer\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /** @var CheckoutService */
    private $service;

    /** @var OrderService */
    private $orderService;

    /**
     * CheckoutController constructor.
     * @param CheckoutService $service
     */
    public function __construct(CheckoutService $service, OrderService $orderService)
    {
        $this->middleware('auth');
        $this->service = $service;
        $this->orderService = $orderService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function process(Request $request)
    {
        return $this->service->process($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentSuccess(Request $request)
    {
        $order = $this->orderService->formatOrderById($request->orderId);

        $update = Order::where('orderId', $order->id)->first();

        if($update->items[2]) {
            $coupon = \App\Models\SystemCoupon::find($update->items[2]['id']);
            if($coupon) {
                $coupon->uses++;
                $coupon->save();
            }
        }

        $update->status = $order->status->origin;
        $update->payment = $order->payment;
        $update->save();

        // return redirect()->route('orders.show', ['id' => $request->orderId]);
    }

    /**
     * @param Request $request
     */
    public function paymentError(Request $request)
    {
        $order = $this->orderService->formatOrderById($request->orderId);

        $update = Order::where('orderId', $order->id)->first();
        $update->status = $order->status->origin;
        $update->save();

        return redirect()->route('orders.show', ['id' => $request->orderId])->with('error', 'Ocorreu algum problema, caso o pedido não tiver mudança no status, entre em contato o mais breve possivel!');
    }
}