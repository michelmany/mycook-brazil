<?php

namespace App\Services\System;

use App\Models\SystemCategory;
use App\Models\SystemSetting;
use Cache;

class CategoryService
{

    const PREFIX = 'system_categories';

    /**
     * Get all categories
     *
     * @return mixed
     */
    public function all()
    {
        $categories = SystemCategory::all();
        return compact('categories');
    }

    /**
     * Get category by id
     * @param SystemCategory $category
     * @return array
     */
    public function findById(SystemCategory $category)
    {
        return compact('category');
    }

    /**
     * Add category
     *
     * @param $payload
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function store($payload)
    {
        try{
            SystemCategory::create($payload);
            return response(null, 204);
        }catch (\Exception $exception) {
            return response()->json(['error' => 'Não foi possivel cadastrar a categoria, atualize a página e tente novamente!.', 'message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Update status category
     *
     * @param SystemCategory $category
     * @param $payload
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(SystemCategory $category, $payload)
    {
        try{
            $category->update($payload);
            return response(null, 204);
        }catch (\Exception $exception) {
            return response()->json(['error' => 'Não foi possivel executar a atualização.', 'message' => $exception->getMessage()], 400);
        }
    }

    /**
     * Delete
     *
     * @param SystemCategory $category
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(SystemCategory $category)
    {
        try{
            $category->delete();
            return response(null, 204);
        }catch (\Exception $exception) {
            return response()->json(['error' => 'Categoria não foi removida', 'message' => $exception->getMessage()], 400);
        }
    }
}