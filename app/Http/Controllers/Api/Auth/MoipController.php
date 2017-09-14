<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\MoipConnectService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MoipController extends Controller
{
    /**
     * @var MoipConnectService
     */
    private $service;

    /**
     * MoipController constructor.
     * @param MoipConnectService $service
     */
    public function __construct(MoipConnectService $service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function authorizeSellerAndGetCode()
    {
        return $this->service->authorize();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sellerGetCredentials(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);
        return $this->service->getSellerAndSaveCredentials();
    }
}
