<?php

namespace App\Http\Controllers\Api\Auth;

use App\Services\Moip\AuthService;
use App\Services\Moip\ConnectService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MoipController extends Controller
{
    /**
     * @var ConnectService
     */
    private $service;

    /**
     * MoipController constructor.
     * @param ConnectService $service
     */
    public function __construct(ConnectService $service)
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
     * @param AuthService $authService
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getPublicKey(AuthService $authService)
    {
        return $authService->publicKeysAndCreate();
    }
}
