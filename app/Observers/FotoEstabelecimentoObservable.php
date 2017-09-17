<?php


namespace App\Observers;

use App\FotoEstabelecimento;
use Illuminate\Support\Facades\Storage;

class FotoEstabelecimentoObservable
{
    public function creating(FotoEstabelecimento $model)
    {
        // if ($model->url->isValid()) {
            $this->upload($model);
        // }
    }

    public function deleting(FotoEstabelecimento $model)
    {
        Storage::delete('products/' . $model->url);
    }

    public function updating(FotoEstabelecimento $model)
    {
        if (is_a($model->url, 'Illuminate\Http\UploadedFile') and $model->url->isValid()) {
            $previous_image = $model->getOriginal('url');

            $this->upload($model);
            Storage::delete('products/' . $previous_image);
        }
    }

    protected function upload(FotoEstabelecimento $model)
    {
        $extension = $model->url->extension();
        $name = bin2hex(openssl_random_pseudo_bytes(8));
        $name = $name . '.' . $extension;

        $model->url->storeAs('products', $name);
        $model->url = $name;
    }
}