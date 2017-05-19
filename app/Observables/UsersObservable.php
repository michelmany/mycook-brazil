<?php


namespace App\Observables;

use App\User;
use Illuminate\Support\Facades\Storage;

class UsersObservable
{
    public function creating(User $model)
    {
        if (is_a($model->avatar, 'Illuminate\Http\UploadedFile') and $model->avatar->isValid()) {
            $this->upload($model);
        }
    }

    public function deleting(User $model)
    {
        Storage::disk('s3')->delete('products/' . $model->avatar);
    }

    public function updating(User $model)
    {
        if (is_a($model->avatar, 'Illuminate\Http\UploadedFile') and $model->avatar->isValid()) {
            $previous_image = $model->getOriginal('avatar');

            $this->upload($model);
            if ($previous_image) {
                Storage::disk('s3')->delete('avatars/' . $previous_image);
            }
        }
    }

    protected function upload(User $model)
    {
        $extension = $model->avatar->extension();
        $name = bin2hex(openssl_random_pseudo_bytes(8));
        $name = $name . '.' . $extension;

        $img = \Image::make($model->avatar->getPathname());
        $img->fit(200);

        Storage::disk('s3')->put('avatar/' . $name, (string)$img->stream());
        $model->avatar = $name;
    }
}