<?php

use Illuminate\Support\Facades\Route;
use Ialpro\Bundesland\Facades\ZipLookup;

Route::get('/bundesland/{zip}', function (string $zip) {
    $state = ZipLookup::stateByZip($zip);
    return $state
        ? response()->json(['zip' => $zip, 'state' => $state])
        : response()->json(['error' => 'Not found'], 404);
});
