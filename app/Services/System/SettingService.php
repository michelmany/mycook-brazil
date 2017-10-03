<?php

namespace App\Services\System;


use App\Models\SystemSetting;

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
        return SystemSetting::first()->data;
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
        $current = SystemSetting::first()->data;

        $payload = $current->each(function ($item, $key) use ($current, $column, $value){
            if($column === $key) {
                $current->forget($key);
                $current[$key] = $value;
            }
            return $current;
        });

        try{
            SystemSetting::first()->update(['data' => $payload]);
            return response(null, 204);
        }catch(\Exception $exception) {
            return response()->isInvalid();
        }
    }
}