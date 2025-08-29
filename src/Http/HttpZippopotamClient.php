<?php

namespace Ialpro\Bundesland\Http;

use Ialpro\Bundesland\Contracts\ZippopotamClientInterface;
use Illuminate\Support\Facades\Http;

class HttpZippopotamClient implements ZippopotamClientInterface
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly string $country,
        private readonly int    $timeoutSeconds
    )
    {
    }

    public function lookupByZip(string $zip): ?array
    {
        $url = rtrim($this->baseUrl, '/') . '/' . $this->country . '/' . $zip;

        $res = Http::timeout($this->timeoutSeconds)
            ->retry(2, 200)
            ->get($url);

        if (!$res->ok()) {
            return null;
        }

        $json = $res->json();
        return is_array($json) ? $json : null;
    }
}
