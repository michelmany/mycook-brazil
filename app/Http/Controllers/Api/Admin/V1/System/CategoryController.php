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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SystemCategory  $systemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SystemCategory $systemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SystemCategory  $systemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemCategory $systemCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemCategory  $systemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemCategory $systemCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemCategory  $systemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemCategory $systemCategory)
    {
        //
    }
}
