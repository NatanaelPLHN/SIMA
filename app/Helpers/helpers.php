<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('routeForRole')) {
    function routeForRole(string $base, string $suffix, mixed $params = []): string
    {
        $role = Auth::user()?->role ?? 'user';
        $routeName = "$role.$base.$suffix";

        return route($routeName, $params);
    }
}
