<?php

namespace App\Services;

use App\Models\Moip\MoipSeller;
use App\User;
use Closure;
use Illuminate\Http\Request;
use Moip\Moip;

class MoipAuthService
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
     * @param Moip $moip
     * @param Request $request
     */
    public function __construct(Moip $moip, Request $request)
    {
        $this->moip = $moip;
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

        $moipSeller = $user->moipseller;

        if($moipSeller->publicKeys) {
            return response()->json(['error' => 'We already have a public key for this seller.'], 401);
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
            $session = $this->moip->getSession();
            return Closure::bind($closure, $this)->call($this, $session);
        }catch (\Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}