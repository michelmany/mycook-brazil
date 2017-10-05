<?php

namespace App\Http\Controllers\Api\Admin\V1\System;

use App\Models\SystemCoupon;
use App\Services\System\CouponService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    /** @var CouponService */
    private $service;

    /**
     * CouponController constructor.
     * @param CouponService $service
     */
    public function __construct(CouponService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->service->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        return $this->service->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SystemCoupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(SystemCoupon $coupon)
    {
        return compact('coupon');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemCoupon  $systemCoupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemCoupon $systemCoupon)
    {
        //
        return $this->service->update($systemCoupon, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemCoupon  $systemCoupon
     * @return mixed|\Illuminate\Http\Response
     */
    public function destroy(SystemCoupon $systemCoupon)
    {
        return $this->service->destroy($systemCoupon);
    }
}
