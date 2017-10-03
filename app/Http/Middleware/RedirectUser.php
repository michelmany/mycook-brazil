<?php

namespace App\Http\Middleware;

use Closure;

class RedirectUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        if (!$user->addresses->first()) {
            return redirect()->to('/minha-conta/enderecos');
        }

        return redirect()->to('/lista-chefs');
    }
}
