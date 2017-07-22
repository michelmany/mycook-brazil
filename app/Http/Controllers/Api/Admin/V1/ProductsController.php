<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ErikFig\Http\Controllers\ApiControllerTrait;
use App\Product;

class ProductsController extends Controller
{
    use ApiControllerTrait;
    protected $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }
}
