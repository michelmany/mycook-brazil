<?php

namespace App\Http\Controllers;

use App\Services\SocialService;
use Illuminate\Http\Request;
use Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return Response
     */
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @return Response
     */
    public function callback(SocialService $service, $provider)
    {
        $user = $service->getOrCreateUser(Socialite::driver($provider)->stateless()->user(), $provider);

        auth()->login($user);

        if (!$user->addresses->first()) {
            return redirect()->to('/minha-conta/enderecos');
        }
        return redirect()->route('lista-chefs-page');
    }
}
