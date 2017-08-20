<?php

namespace App\Http\Controllers\Api\Admin\V1;

use Illuminate\Http\Request;
use ErikFig\Http\Controllers\ApiControllerTrait;
use App\Http\Controllers\Controller;
use App\Product;

class ProductsController extends Controller
{
    use ApiControllerTrait;
    protected $model;
    protected $relationships = ['extras'];

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function photo(Request $request, $id)
    {
        $product = $this->model->findOrFail($id);
        $product->photo = $request->all()['photo'];
        $product->save();
        return response()->json(['status'=>'ok']);
    }

}
