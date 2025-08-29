<?php

namespace Ialpro\Bundesland\Contracts;

interface ZippopotamClientInterface
{
    /**
     * @return array{places: array<array-key, array<string, mixed>>}|null
     */
    public function lookupByZip(string $zip): ?array;
}
