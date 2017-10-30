<?php

namespace App\Services\System;

use App\Models\SystemCoupon;
use App\Models\SystemSetting;
use Cache;
use Carbon\Carbon;

class CouponService
{

    const PREFIX = 'system_coupons';

    /** @var  SettingService */
    private $subservice;

    /**
     * CouponService constructor.
     * @param SettingService $subservice
     */
    public function __construct(SettingService $subservice)
    {
        $this->subservice = $subservice;
    }

    /**
     * Get all settings
     *
     * @return mixed
     */
    public function all()
    {
        $coupons = SystemCoupon::all();

        return compact('coupons');
    }

    /**
     * Store coupon
     *
     * @param array $payload
     */
    public function store($payload)
    {
        $payload['expires_in'] = Carbon::now()->addDays($this->subservice->get('coupon_expires_in') ?? 5);
        $payload['code'] = studly_case(strtoupper($payload['code']));

        try{
            SystemCoupon::create($payload);
            return response(null, 201);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * Coupon Update
     *
     * @param SystemCoupon $coupon
     * @param $payload
     */
    public function update(SystemCoupon $coupon, $payload)
    {
        unset($payload['updated_at'], $payload['uses']);
        $payload['code'] = studly_case(strtoupper($payload['code']));

        try{
           $coupon->update($payload);
            return response(null, 204);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * Get value setting
     *
     * @param SystemCoupon $coupon
     * @param $setting
     * @return mixed
     */
    public function get(SystemCoupon $coupon, $setting)
    {
        try{
            if($coupon->settings->has($setting)) {
                return $coupon->settings->get($setting);
            }
        }catch(\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    /**
     * Delete coupon
     *
     * @param SystemCoupon $coupon
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(SystemCoupon $coupon)
    {
        try{
            $coupon->delete();
            return response(null, 204);
        }catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}