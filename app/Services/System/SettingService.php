<?php

namespace App\Services\System;

use App\Models\SystemSetting;
use Cache;

class SettingService
{

    const PREFIX = 'system_settings';

    /**
     * Get all settings
     *
     * @return mixed
     */
    public function all()
    {
        return Cache::rememberForever(self::PREFIX, function() {
            return SystemSetting::first()->data;
        });
    }

    /**
     * Update setting
     *
     * @param $column
     * @param $value
     * @return bool
     */
    public function updateSetting($column, $value)
    {
        $current = Cache::get(self::PREFIX);

        $payload = $current->each(function ($item, $key) use ($current, $column, $value){
            if($column === $key) {
                $current->forget($key);
                $current[$key] = $value;
            }
            return $current;
        });

        // remove cache storage
        Cache::forget(self::PREFIX);

        try{
            SystemSetting::first()->update(['data' => $payload]);
            return response(null, 204);
        }catch(\Exception $exception) {
            return response()->isInvalid();
        }
    }

    /**
     * Get value setting
     *
     * @param $setting
     * @return mixed
     */
    public function get($setting)
    {
        $all = $this->all();

        try{
            if($all->has($setting)) {
                return $all->get($setting);
            }
        }catch(\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }
}