<?php

namespace App\Services\Moip;

use App\Models\Moip\MoipSeller;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Moip\Moip;

class AuthService
{
    /**
     * @var Moip
     */
    private $moip;

    /**
     * @var Request
     */
    private $request;

    /**
     * MoipAuthService constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->moip = \Moip::start();
        $this->request = $request;
    }

    /**
     * Request seller's public key and save to bank if none exist
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function publicKeysAndCreate()
    {
        $user = $this->request->user();

        if($user->role !== 'vendedor') {
            return response()->json(['error' => 'Sua conta deve ser do tipo VENDEDOR'], 403);
        }

        $moipSeller = $user->moipseller;

        if(!$moipSeller) {
            return response()->json(['error' => 'Antes de solicitar sua chave pública, é necessário sincronizar sua conta com nossa APP'], 403);
        }

        if($moipSeller->publicKeys) {
            return response()->json(['error' => 'Você já solicitou sua chave pública.'], 401);
        }
        return $this->proxy(function($proxy) use($moipSeller){
            $response = $proxy->get('v2/keys');
            $body = json_decode($response->body, true);
            $moipSeller->publicKeys()->create([
                'data' => $body
            ]);

            return response()->json(['data' => 'created'], 201);
        });

    }

    /**
     * @param null $closure
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    private function proxy($closure = null) {
        try{
            $session = $this->moip->getApi()->getSession();
            return Closure::bind($closure, $this)->call($this, $session);
        }catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}