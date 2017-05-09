<?php


namespace App\Http\Controllers\Api\Admin\V1;

use ErikFig\Http\Controllers\ApiControllerTrait;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    use ApiControllerTrait;
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }
}