<?php

/**
 * Panel-aware route helpers for DiagnoLap.
 *
 * These helpers resolve route names dynamically based on the authenticated
 * user's role, mapping to either the 'admin.*' or 'teknisi.*' route group.
 */

if (!function_exists('panel_prefix')) {
    /**
     * Get the current user's panel route-name prefix ('admin' or 'teknisi').
     */
    function panel_prefix(): string
    {
        if (auth()->check() && auth()->user()->isTeknisi()) {
            return 'teknisi';
        }

        return 'admin';
    }
}

if (!function_exists('panel_route')) {
    /**
     * Generate a URL for a named route using the current user's panel prefix.
     *
     * Usage: panel_route('dashboard')        → route('admin.dashboard') or route('teknisi.dashboard')
     *        panel_route('riwayat.show', $r) → route('admin.riwayat.show', $r) or route('teknisi.riwayat.show', $r)
     */
    function panel_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return route(panel_prefix() . ".{$name}", $parameters, $absolute);
    }
}

if (!function_exists('panel_routeIs')) {
    /**
     * Check if the current route matches a pattern for either panel prefix.
     *
     * Usage: panel_routeIs('dashboard')   → true if on admin.dashboard OR teknisi.dashboard
     *        panel_routeIs('riwayat.*')   → true if on admin.riwayat.* OR teknisi.riwayat.*
     */
    function panel_routeIs(string $pattern): bool
    {
        return request()->routeIs("admin.{$pattern}") || request()->routeIs("teknisi.{$pattern}");
    }
}
