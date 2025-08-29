<?php

namespace Ialpro\Bundesland\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null stateByZip(string $zip)
 * @method static \Ialpro\Bundesland\Support\DTO\PostalLookupResult lookup(string $zip, ?string $city = null)
 */
class ZipLookup extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Ialpro\Bundesland\Contracts\ZipLookupServiceInterface::class;
    }
}
