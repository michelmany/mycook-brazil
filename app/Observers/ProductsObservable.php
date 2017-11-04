<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductsObservable
{
    public function creating(Product $model)
    {
        if (is_a($model->photo, 'Illuminate\Http\UploadedFile') and $model->photo->isValid()) {
            $this->upload($model);
        }
    }

    public function deleting(Product $model)
    {
        Storage::disk('s3')->delete('avatar/products' . $model->photo);
    }

    public function updating(Product $model)
    {
        if (is_a($model->photo, 'Illuminate\Http\UploadedFile') and $model->photo->isValid()) {
            $previous_image = $model->getOriginal('photo');

            $this->upload($model);
            if ($previous_image) {
                Storage::disk('s3')->delete('avatar/products/' . $previous_image);
            }
        }
    }

    protected function upload(Product $model)
    {
        $extension = $model->photo->extension();
        $name = bin2hex(openssl_random_pseudo_bytes(8));
        echo 'update: ' . $name = $name . '.' . $extension;

        $img = \Image::make($model->photo->getPathname());
        // $img->fit(800, 600);
        
        // prevent possible upsizing
        $img->resize(null, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('s3')->put('avatar/products/' . $name, (string)$img->stream());

        $model->photo = $name;
    }
}