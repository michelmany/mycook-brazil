<?php


namespace App\Http\Controllers\Api\Admin\V1;

use App\Models\Buyer;
use Illuminate\Http\Request;
use App\Models\Seller;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\Admin\V1\ApiControllerTrait;
use App\User;

class UsersController extends Controller
{
    use ApiControllerTrait;
    protected $model;
    protected $relationships = ['buyer', 'seller.fotos', 'addresses'];

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function avatar(Request $request, $id)
    {
        $user = $this->model->findOrFail($id);
        $user->avatar = $request->all()['avatar'];
        $user->save();
        return response()->json(['status'=>'ok']);
    }

    public function store(Request $request)
    {
        $result = $this->model->create($request->all());
        $result->update($request->all());

        if (!empty($request->all()['buyer'])) {
            Buyer::firstOrCreate(['user_id'=>$result->id], $request->all()['buyer']);
        }

        if (!empty($request->all()['seller'])) {
            Seller::firstOrCreate(['user_id'=>$result->id], $request->all()['seller']);
        }

        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $result = $this->model->findOrFail($id);
        $result->update($request->all());

        if (!empty($request->all()['buyer'])) {
            $buyer = Buyer::firstOrCreate(['user_id'=>$id], $request->all()['buyer']);
            $buyer->update($request->all()['buyer']);
        }

        if (!empty($request->all()['seller'])) {
            $seller = Seller::firstOrCreate(['user_id'=>$id], $request->all()['seller']);
            $seller->update($request->all()['seller']);
        }

        return response()->json($result);
    }
}