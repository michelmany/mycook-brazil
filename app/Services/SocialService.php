<?php


namespace App\Services;

use App\Social;
use App\User;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialService
{
    public function getOrCreateUser(SocialiteUser $providerUser, $provider)
    {
        $account = Social::where([
            'provider' => $provider,
            'provider_user_id' => $providerUser->getId(),
        ])->first();

        if ($account) {
            return $account->user;
        }

        $user = User::where('email', $providerUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'cpf' => '',
                'role' => 'comprador',
            ]);
        }

        $account = new Social;
        $account->provider = $provider;
        $account->provider_user_id = $providerUser->getId();

        $account->user()->associate($user);

        return $user;
    }
}