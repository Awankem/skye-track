<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists('setting')) {
    /**
     * Get a setting value from the database.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        return Cache::rememberForever('setting.' . $key, function () use ($key, $default) {
            $setting = Setting::find($key);
            if ($setting) {
                $value = $setting->value;
                // Attempt to decode JSON strings
                if (is_string($value)) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return $decoded;
                    }
                }
                return $value;
            }
            return $default;
        });
    }
}
