<?php

namespace App\Http\Controllers\Api\Admin\V1\System;

use App\Services\System\SettingService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /** @var  SettingService */
    private $service;

    /**
     * SettingController constructor.
     * @param SettingService $service
     */
    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->all();
    }

    public function update(Request $request)
    {
        return $this->service->updateSetting($request->column, $request->value);
    }
}
