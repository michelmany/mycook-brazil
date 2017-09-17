<?php

namespace App\Support\Moip;

use Closure;
use Exception;
use Moip\Auth\Connect;

class ConnectSupport
{
    /**
     * @param null $closure
     * @return mixed
     */
    public static function proxy($closure)
    {
        $marketplace = (object)config('moip.marketplace');

        try{
            $connect = new Connect(
                $marketplace->redirect,
                $marketplace->id,
                true,
                $marketplace->endpoint
            );

            return Closure::bind($closure, new static())->call(new static(), $connect);

        }catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}