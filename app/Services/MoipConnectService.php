<?php

namespace App\Services;

use App\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Moip\Auth\Connect;
use Moip\Auth\OAuth;
use Moip\Moip;

class MoipConnectService
{
    /**
     * @var mixed
     */
    private $marketplace;

    /**
     * @var Request
     */
    private $request;

    /**
     * MoipConnectService constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->marketplace = (object) config('moip.marketplace');
        $this->request = $request;
    }

    /**
     * Request permissions
     *
     * @param null|array $scopes
     * @return mixed
     */
    public function authorize($scopes = null)
    {
        if(auth()->user()->role !== 'vendedor') {
            return response()->json(['error' => 'account type not supported!'], 403);
        }

        if(null !== auth()->user()->moipseller) {
            return response()->json(['error' => 'your account already has a relationship'], 403);
        }

        return $this->proxy(function(Connect $connect) use ($scopes){
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
        return $this->proxy(function(Connect $connect) {
            $connect->setClientSecret($this->marketplace->secret);
            $connect->setCode($this->request->get('code'));
            /** @var User $user */
            $user = auth()->user();
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

            return redirect()->to('moip/marketplace/authorize');
        });
    }

    /**
     * @param null $closure
     * @return mixed
     */
    private function proxy($closure)
    {
        try{
            $connect = new Connect(
                $this->marketplace->redirect,
                $this->marketplace->id,
                true,
                $this->marketplace->endpoint
            );
            return Closure::bind($closure, $this)->call($this, $connect);
        }catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}