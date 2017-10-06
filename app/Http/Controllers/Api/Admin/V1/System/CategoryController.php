<?php

namespace App\Http\Controllers\Api\Admin\V1\System;

use App\Models\SystemCategory;
use App\Services\System\CategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /** @var  CategoryService */
    private $service;

    /**
     * CategoryController constructor.
     * @param CategoryService $service
     */
    public function __construct(CategoryService $service)
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
        //
        return $this->service->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SystemCategory  $systemCategory
     * @return mixed|\Illuminate\Http\Response
     */
    public function show(SystemCategory $systemCategory)
    {
        //
        return $this->service->findById($systemCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemCategory  $systemCategory
     * @return mixed|\Illuminate\Http\Response
     */
    public function update(Request $request, SystemCategory $systemCategory)
    {
        return $this->service->update($systemCategory, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemCategory  $systemCategory
     * @return mixed|\Illuminate\Http\Response
     */
    public function destroy(SystemCategory $systemCategory)
    {
        //
        return $this->service->destroy($systemCategory);
    }
}
