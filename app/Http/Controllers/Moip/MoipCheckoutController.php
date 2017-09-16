<?php

namespace App\Http\Controllers\Moip;

use App\Http\Controllers\Controller;
use App\Services\MoipCheckoutService;
use Illuminate\Http\Request;

class MoipCheckoutController extends Controller
{
    /** @var MoipCheckoutService */
    private $service;

    /**
     * MoipCheckoutController constructor.
     * @param MoipCheckoutService $service
     */
    public function __construct(MoipCheckoutService $service)
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