<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IncompleteProfile
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
        /**
         * Verificamos se o usuário está online,
         * Se não estiver online renderizamos a página normalmente
         */
        $user = Auth::user();
        if (!$user) {
            return $next($request);
        }

        /**
         * Verificamos se a rota é de formulário de perfil ou salvamento
         * Se for renderizamos normalmente
         */
        $routeName = \Request::route()->getName();
        if ($routeName === 'profile' || $routeName === 'profileSave') {
            return $next($request);
        }

        /**
         * Verificamos se o usuário tem email ou cpf preenchidos
         * Se estiver em branco algum dos dois, redirecionamos para edição de perfil
         * O usuário fica travado lá até preencher os dados
         */
        if (empty($user->email) || empty($user->cpf)) {
            return redirect()->route('profile');
        }

        /**
         * Renderizamos normalmente
         */
        return $next($request);
    }
}
