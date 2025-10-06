<?php

use Illuminate\Support\Facades\Auth;

if (! function_exists('routeForRole')) {
    function routeForRole(string $base, string $suffix): string {
        $role = Auth::user()?->role ?? 'user';
        // return "$role.$base.$suffix";
        return route("$role.$base.$suffix");
    }
}
