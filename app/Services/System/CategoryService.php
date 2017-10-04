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
        return SystemCategory::all();
    }
}