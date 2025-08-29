<?php

namespace Ialpro\Bundesland\Support\DTO;

final class PostalLookupResult
{
    public function __construct(
        public readonly bool    $ok,
        public readonly ?string $zip,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly ?string $message
    )
    {
    }

    public static function ok(string $zip, ?string $city, ?string $state): self
    {
        return new self(true, $zip, $city, $state, null);
    }

    public static function fail(string $message, ?string $zip = null, ?string $city = null, ?string $state = null): self
    {
        return new self(false, $zip, $city, $state, $message);
    }
}
