<?php

use Ialpro\Bundesland\Facades\ZipLookup;

if (!function_exists('bundesland')) {
    function bundesland(string $zip, ?string $city = null): ?string
    {
        $res = ZipLookup::lookup($zip, $city);
        return $res->ok ? $res->state : null;
    }
}
