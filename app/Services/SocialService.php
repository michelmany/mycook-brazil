<?php


namespace App\Services;

use App\Models\Social;
use App\User;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use File;

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

            // To add avatar
            $fileContents = file_get_contents($providerUser->getAvatar());
            File::put(public_path() . '/uploads/profile/' . $providerUser->getId() . ".jpg", $fileContents);
            $fileName = $providerUser->getId() . ".jpg";

            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'avatar' => $fileName,
                'cpf' => '',
                'role' => 'comprador',
            ]);
        }

        // $account = new Social;
        // $account->provider = $provider;
        // $account->provider_user_id = $providerUser->getId();

        $account = Social::create([
            'user_id' => $user->id,
            'provider_user_id' => $providerUser->getId(),
            'provider' => $provider,
        ]);

        $account->user()->associate($user);

        return $user;
    }
}