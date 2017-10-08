<?php

namespace App\Services\System;

use App\Models\Seller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SellerService
{
    /** @var User */
    private $user;

    /**
     * SellerService constructor.
     */
    public function __construct()
    {
        $this->user = \JWTAuth::toUser( \JWTAuth::getToken() );
    }

    /**
     * Get account
     * @param User $user
     * @return array
     */
    public function find(User $user)
    {
        $seller = $user->seller;;
        return compact('seller');
    }

    /**
     * @param Seller $seller
     * @param Request $request
     */
    public function update(Seller $seller, Request $request)
    {
        /** @var Collection $data */
        $data = $seller->data;

        $payload = null;

        if($request->hasFile('avatar')) {

            if($data->has('avatar')) {
                \Storage::disk('s3')->delete('avatar/' . $data->get('avatar'));
            }

            $payload = [
                'avatar' => $this->uploadImage($request->file('avatar'))
            ];

        }else{
            $payload = $request->all();
        }
        $key = array_keys($payload)[0];
        $value = array_values($payload)[0];

        if($data->isEmpty()) {
            $data->put($key, $value);
        }else{
            $data->each(function($item, $index) use ($data, $key, $value){
                if($index === $key) {
                    $data->forget($index);
                    $data->put($key, $value);
                }else{
                    $data->put($key, $value);
                }
                return $data;
            });
        }

        try{
            $seller->update(['data' => $data]);
            return response(null, 204);
        }catch(\Exception $exception) {
            return response()->isInvalid();
        }

    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private function uploadImage(UploadedFile $file)
    {
        $extension = $file->extension();

        $name = bin2hex(openssl_random_pseudo_bytes(8));
        $name = $name . '.' . $extension;

        $img = \Image::make($file->getPathname());
        $img->fit(200);

        \Storage::disk('s3')->put('avatar/sellers/' . $name, (string)$img->stream());

        //
        return 'https://s3-' . env('AWS_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/avatar/sellers/' . $name;
    }
}