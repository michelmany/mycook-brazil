<?php

namespace App\Http\Controllers\Moip;

use App\Http\Controllers\Controller;
use App\Mail\AdminOrderPaidMail;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderDeliveryData;
use App\Models\Seller;
use App\Services\Moip\CheckoutService;
use App\Services\Moip\Customer\OrderService;
use App\Support\Moip\Utils as MoipUtil;
use App\User;
use Carbon\Carbon;
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

        $update = Order::where('orderId', $order->id)->with('buyer')->first();
        $items = collect($update->items);

        $items->each(function($item) {
            if(isset($item['type']) && $item['type'] === 'coupon') {
                $coupon = \App\Models\SystemCoupon::find($item['id']);
                if($coupon) {
                    $coupon->uses++;
                    $coupon->save();
                }
            }
        });

        $update->status = $order->status->origin;
        $update->payment = $order->payment;
        $update->save();

        // get order details to send by email (time and address)
        $details = OrderDeliveryData::where('order_id', $update->id)->first();
        $buyer_address = Address::where('id', $details->address_id)->first();
        $buyer = User::where('id', $buyer_address['user_id'])->first();
        $seller = Seller::where('id', $update['seller_id'])->with('user')->first();
        $buyer->ddd = substr($update->buyer['phone'], 0 ,2);
        $buyer->phone = substr($update->buyer['phone'], 2);
        $seller->ddd = substr($update->seller['phone'], 0 ,2);
        $seller->phone = substr($update->seller['phone'], 2);

        $dt = MoipUtil::formatDate($details->time->toDateTimeString())->format('d/m/Y H:i');

        //set order array
        $order->time = $dt;
        $order->buyer = collect($buyer);
        $order->seller = collect($seller);
        $buyer_address = collect($buyer_address);
        unset($order->buyer['password']);

        // dd($update->seller['user']['email']);

        if($order->status->origin === 'PAID') {
            \Mail::to(config('mail.contact'))
            ->cc($update->seller['user']['email'])
            ->send(new AdminOrderPaidMail($order, $buyer_address));
        }

        return redirect()->route('orders.show', ['id' => $request->orderId]);
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