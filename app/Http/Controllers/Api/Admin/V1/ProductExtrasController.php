<?php

namespace App\Http\Controllers\Api\Admin\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Admin\V1\ApiControllerTrait;
use App\Http\Controllers\Controller;
use App\Models\ProductExtra;

class ProductExtrasController extends Controller
{
    use ApiControllerTrait;
    protected $model;

    public function __construct(ProductExtra $model)
    {
        $this->model = $model;
    }

    public function update(Request $request, $id)
    {
        foreach ($request->all() as $extra) {
            $extra = array_merge($extra, ['product_id' => $id]);
            $result = $this->model->updateOrCreate(['product_id' => $id, 'date' => $extra['date']], $extra);
        }

        return response()->json($result);
    }
}
