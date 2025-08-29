<?php

namespace Ialpro\Bundesland\Services;

use Ialpro\Bundesland\Contracts\ZipLookupServiceInterface;
use Ialpro\Bundesland\Contracts\ZippopotamClientInterface;
use Ialpro\Bundesland\Support\DTO\PostalLookupResult;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class ZipLookupService implements ZipLookupServiceInterface
{
    public function __construct(
        private readonly ZippopotamClientInterface $client,
        private readonly CacheRepository           $cache,
        private readonly int                       $cacheTtlSeconds
    )
    {
    }

    public function stateByZip(string $zip): ?string
    {
        $res = $this->lookup($zip);
        return $res->ok ? $res->state : null;
    }

    public function lookup(string $zip, ?string $city = null): PostalLookupResult
    {
        $cacheKey = "bundesland:$zip";
        $payload = $this->cache->remember($cacheKey, $this->cacheTtlSeconds, function () use ($zip) {
            return $this->client->lookupByZip($zip);
        });

        if (!is_array($payload) || empty($payload['places'])) {
            return PostalLookupResult::fail('ZIP not found', $zip);
        }

        $first = $payload['places'][0] ?? [];
        $foundCity = $first['place name'] ?? null;
        $foundState = $first['state'] ?? null;

        if ($city !== null) {
            $matches = collect($payload['places'])->contains(function ($p) use ($city) {
                return isset($p['place name']) && mb_strtolower($p['place name']) === mb_strtolower($city);
            });

            if (!$matches) {
                return PostalLookupResult::fail('City does not match ZIP', $zip, $foundCity, $foundState);
            }
        }

        return PostalLookupResult::ok($zip, $foundCity, $foundState);
    }
}
