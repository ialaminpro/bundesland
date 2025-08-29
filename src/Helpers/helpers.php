<?php

use Ialpro\Bundesland\Facades\ZipLookup;

if (! function_exists('bundesland')) {
    /**
     * Return Bundesland (state) for a German PLZ.
     * If $city is provided, it must match the ZIP; otherwise null is returned.
     */
    function bundesland(string $zip, ?string $city = null): ?string
    {
        // Normalize PLZ (keep digits only) and validate
        $zip = preg_replace('/\D+/', '', $zip);
        if (!preg_match('/^\d{5}$/', $zip)) {
            return null;
        }

        try {
            // No city check needed → use fast path
            if ($city === null) {
                return ZipLookup::stateByZip($zip); // already returns ?string
            }

            // With city verification → use full lookup DTO
            $res = ZipLookup::lookup($zip, $city); // DTO: ok, zip, city, state, message
            return $res->ok ? $res->state : null;
        } catch (\Throwable $e) {
            // Be graceful; service may throw on unexpected errors
            return null;
        }
    }
}
