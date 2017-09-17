<?php

namespace App\Services\Moip;

use JWTAuth;
use Carbon\Carbon;
use Moip\Auth\Connect;
use Illuminate\Support\Facades\Cache;
use App\Support\Moip\ConnectSupport;

class ConnectService
{

    /**
     * @var Cache
     */
    private $cache;

    /**
     * MoipConnectService constructor.
     */
    public function __construct()
    {
        $this->cache = Cache::getFacadeRoot();
    }

    /**
     * Verificar se vendedor está sincronizado com moip marketplace
     */
    public function verifySellerSync()
    {
        $user = JWTAuth::toUser($this->cache->get('auth.token') ?? \request()->get('token'));

        $moipSeller = $user->moipseller;

        if(!$moipSeller) {
            return response()->json(['error' => 'user not sync'], 412);
        }

        return response()->json(
            [
                'data' => [
                    'moipId' => $moipSeller->moipAccount,
                    'moipAccessToken'   => $moipSeller->data['accessToken']
                ]
            ]
        );
    }

    /**
     * Request permissions
     *
     * @param null|array $scopes
     * @return mixed
     */
    public function authorize($scopes = null)
    {
        $token = request()->get('token');

        $this->cache->add('auth.token', $token, Carbon::now()->addMinutes(5));

        $user = JWTAuth::toUser($token);

        if($user->role !== 'vendedor') {
            return response()->json(['error' => 'account type not supported!'], 403);
        }

        if(null !== $user->moipseller) {
            return response()->json(['error' => 'your account already has a relationship'], 403);
        }

        return ConnectSupport::proxy(function(Connect $connect) use ($scopes){
            $connect->setScodeAll(true);
            header('Location: ' . $connect->getAuthUrl());
        });
    }

    /**
     * @param null|array $scopes
     */
    public function refreshToken($scopes = null)
    {
        // fazer depois por conta da complexibilidade e falta de tempo...
    }

    /**
     * Obtem código vindo da autorização e salva dados no banco.
     *
     * @return mixed
     */
    public function getSellerAndSaveCredentials()
    {
        $user = JWTAuth::toUser($this->cache->get('auth.token'));

        return ConnectSupport::proxy(function(Connect $connect) use ($user){
            $connect->setClientSecret(config('moip.marketplace.secret'));
            $connect->setCode(request()->get('code'));

            $payload = $connect->authorize();

            $user->moipseller()->create([
                'moipAccount' => $payload->moipAccount->id,
                'data' => [
                    'accessToken' => $payload->access_token,
                    'refreshToken' => $payload->refresh_token,
                    'scope' => $payload->scope,
                    'expiresIn' => $payload->expires_in
                ]
            ]);

            return redirect()->intended('painel/admin/settings/moip');
        });
    }
}