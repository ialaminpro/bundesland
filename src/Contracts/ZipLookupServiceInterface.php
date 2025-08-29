<?php

namespace Ialpro\Bundesland\Contracts;

use Ialpro\Bundesland\Support\DTO\PostalLookupResult;

interface ZipLookupServiceInterface
{
    public function stateByZip(string $zip): ?string;

    public function lookup(string $zip, ?string $city = null): PostalLookupResult;
}
