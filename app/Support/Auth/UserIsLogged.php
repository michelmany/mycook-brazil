<?php

namespace App\Support\Auth;

use Illuminate\Http\Request;

class UserIsLogged
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function run(Request $request)
    {
        if($request->expectsJson()) {
            return response()->json([
                'data' => !\Auth::guest()
            ]);
        }
        abort(401, 'not authorized');
    }

}