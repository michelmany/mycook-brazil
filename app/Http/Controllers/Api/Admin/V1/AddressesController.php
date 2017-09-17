<?php

namespace App\Http\Controllers\Api\Admin\V1;

use Illuminate\Http\Request;
use ErikFig\Http\Controllers\ApiControllerTrait;
use App\Http\Controllers\Controller;
use App\Models\Address;

class AddressesController extends Controller
{
    use ApiControllerTrait;
    protected $model;

    public function __construct(Address $model)
    {
        $this->model = $model;
    }
}