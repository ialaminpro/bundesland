# 🇩🇪 Laravel Bundesland Lookup

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ialpro/bundesland.svg)](https://packagist.org/packages/ialpro/bundesland)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

A Laravel package to look up the **German Bundesland (federal state)** by **postal code (PLZ)**, optionally verifying the city, using the [Zippopotam.us](http://www.zippopotam.us) API.

It provides a **Facade**, **global helper**, and **optional API route** — with caching for efficiency.

---

## 🚀 Installation

Require the package via Composer:

```bash
composer require ialpro/bundesland
```

---

## ⚙️ Configuration

Publish the config (optional):

```bash
php artisan vendor:publish --tag=bundesland-config
```

This will create `config/zippopotam.php`:

```php
return [
    'base_url'         => env('ZIPPOPOTAM_BASE_URL', 'https://api.zippopotam.us'),
    'country'          => env('ZIPPOPOTAM_COUNTRY', 'de'),
    'timeout'          => (int) env('ZIPPOPOTAM_TIMEOUT', 5),
    'cache_ttl'        => (int) env('ZIPPOPOTAM_CACHE_TTL', 21600), // 6h
    'enable_api_route' => (bool) env('BUNDESLAND_ENABLE_API', false),
];
```

---

## 🧑‍💻 Usage

### Using the Facade

```php
use Ialpro\Bundesland\Facades\ZipLookup;

// Get Bundesland directly
$state = ZipLookup::stateByZip('10115'); // "Berlin"

// Full lookup with city check
$res = ZipLookup::lookup('80331', 'München');
if ($res->ok) {
    echo $res->state; // "Bayern"
} else {
    echo $res->message; // e.g. "City does not match ZIP"
}
```

### Using the Helper

```php
$state = bundesland('20095');                // "Hamburg"
$stateWithCheck = bundesland('80331','München'); // "Bayern"
```

### In Blade

```blade
<p>ZIP 10115 → {{ bundesland('10115') }}</p>
<p>ZIP 80331 + München → {{ bundesland('80331', 'München') }}</p>
```

---

## 🌐 Optional API Route

Enable in `.env`:

```
BUNDESLAND_ENABLE_API=true
```

This activates:

```
GET /api/bundesland/{zip}
```

Example:

```json
GET /api/bundesland/10115
{
  "zip": "10115",
  "state": "Berlin"
}
```

---

## 🧪 Testing

You can test with [Orchestra Testbench](https://github.com/orchestral/testbench).

Example:

```php
public function test_lookup_berlin()
{
    $state = \Ialpro\Bundesland\Facades\ZipLookup::stateByZip('10115');
    $this->assertEquals('Berlin', $state);
}
```

---

## 📜 License

MIT © Al Amin
