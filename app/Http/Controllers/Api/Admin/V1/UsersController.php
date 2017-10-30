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
        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));

        $result = $this->model->create($data);
        $result->update($data);

        if (!empty($data['buyer'])) {
            Buyer::firstOrCreate(['user_id'=>$result->id], $data['buyer']);
        }

        if (!empty($data['seller'])) {
            Seller::firstOrCreate(['user_id'=>$result->id], $data['seller']);
        }

        return response()->json($result);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['password'] = bcrypt($request->input('password'));
        
        $result = $this->model->findOrFail($id);
        $result->update($data);

        if (!empty($data['buyer'])) {
            $buyer = Buyer::firstOrCreate(['user_id'=>$id], $data['buyer']);
            $buyer->update($data['buyer']);
        }

        if (!empty($data['seller'])) {
            $seller = Seller::firstOrCreate(['user_id'=>$id], $data['seller']);
            $seller->update($data['seller']);
        }

        return response()->json($result);
    }
}