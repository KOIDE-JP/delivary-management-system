<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $this->checkPermission($request);
        if ($response) {
            return $response;
        }
        return $next($request);
    }

    public function checkPermission(Request $request)
    {
        $user = auth()->user();

        if (! $user->role) {
            return back()->with('error', "You don't have access on this page");
        } else {
            $permissions = $user->role->permissions->pluck('slug')->toArray();
            $current_route_name = $request->route()->getName();
            if ($current_route_name && $current_route_name != 'admin.dashboard') {
                if (! in_array($current_route_name, $permissions)) {
                    return redirect()->back()->with('error', __('layouts.no_access_to_this_route'));
                }
            }
        }
    }
}
