<?php

namespace App\Http\Controllers\Moip;

use App\Http\Controllers\Controller;
use App\Services\Moip\CheckoutService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /** @var CheckoutService */
    private $service;

    /**
     * CheckoutController constructor.
     * @param CheckoutService $service
     */
    public function __construct(CheckoutService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function process(Request $request)
    {
        return $this->service->process($request);
    }
}