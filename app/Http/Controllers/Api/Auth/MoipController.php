<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\MoipAuthService;
use App\Services\MoipConnectService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Moip\Auth\Connect;

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
    public function checkSellerAuthorization()
    {
        return $this->service->verifySellerSync();
    }

    /**
     * Request permission for the seller
     *
     * @return mixed
     */
    public function authorizeSellerAndGetCode()
    {
        return $this->service->authorize();
    }

    /**
     * @return string
     */
    public function refreshSellerAndUpdate()
    {
        return 'refresh_token';
    }

    /**
     * Obtain credentials from the seller from the code received by the order
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

    /**
     * @param MoipAuthService $authService
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getPublicKey(MoipAuthService $authService)
    {
        return $authService->publicKeysAndCreate();
    }
}
