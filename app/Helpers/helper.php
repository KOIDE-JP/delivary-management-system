<?php

use App\Models\ActivityLog;
use App\Models\Status;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

if (!function_exists('hasAnyPermissions')) {

    function hasAnyPermissions($permission)
    {
        if (auth()->user()->role_id == 1) {
            return true;
        }
        $guard = getCurrentGuard();
        return auth($guard)->user()->hasPermission($permission);
    }
}

if (!function_exists('getAllRoutesInArray')) {
    function getAllRoutesInArray(): array
    {
        $data = [];
        foreach (Route::getRoutes() as $key => $route) {
            if ($route->getName() && $route->getPrefix() != '' && $route->getPrefix() != '_ignition') {
                $data[$key] = [
                    'name' => $route->getName(),
                    'prefix' => $route->getPrefix(),
                ];
            }
        }
        $arr = array();
        foreach ($data as $key => $item) {
            $arr[$item['prefix']][$key] = $item;
        }
        ksort($arr, SORT_NUMERIC);
        return $arr;
    }
}

if (!function_exists('getCurrentGuard')) {
    function getCurrentGuard(): string
    {
        $guards = array_keys(config('auth.guards'));
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }
    }
}

if (!function_exists('hasStatusPermission')) {

    function hasStatusPermission($status_id)
    {
        try {
            if (!auth()->check()) {
                return false;
            }

            if (auth()->user()->role_id == 1 || auth()->user()->role->slug == 'super-admin') {
                return true;
            }

            $status = Status::find($status_id);
            if (!$status) {
                return false;
            }

            $role_ids = json_decode($status->role_ids ?? '[]', true) ?? [];
            if (empty($role_ids)) {
                return false;
            }

            if (!auth()->user()->role) {
                return false;
            }

            return in_array((string) auth()->user()->role->id, $role_ids);
        } catch (\Exception $e) {
            Log::error('Error in hasStatusPermission: ' . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('logActivity')) {
    function logActivity(
        $model,
        string $action,          // lang key  e.g. 'layouts.action_created'
        string $message = '',    // lang key  e.g. 'layouts.freight_rate_created'
        string $status = 'success' // lang key e.g. 'layouts.status_success'
    ): void {
        try {
            ActivityLog::create([
                'user_id'       => auth()->id(),
                'loggable_type' => get_class($model),
                'loggable_id'   => $model->getKey(),
                'action'        => $action,
                'log_status'    => $status,
                'log_message'   => $message
                                    ? $message
                                    : $action . ' ' . class_basename($model) . ' #' . $model->getKey(),
            ]);
        } catch (\Exception $e) {
            Log::error('Activity log failed: ' . $e->getMessage());
        }
    }
}