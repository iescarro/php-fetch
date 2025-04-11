# PHP Fetch

A simple, lightweight PHP function inspired by JavaScript's `fetch()`, using cURL under the hood. Supports method, headers, and body customization — perfect for quick API calls.

## 📦 Installation

Use [Composer](https://getcomposer.org) to install:

```bash
composer require iescarro/php-fetch
```

## 🚀 Usage

```php
<?php

require 'vendor/autoload.php';

use function PhpFetch\fetch;

fetch('https://jsonplaceholder.typicode.com/posts', [
    'method' => 'POST',
    'headers' => [
        'Content-Type' => 'application/json',
    ],
    'body' => [
        'title' => 'Hello',
        'body' => 'World!',
        'userId' => 1,
    ],
], function ($response) {
    print_r($response);
});
```

## 🧰 Options

|Key | Type | Description |
|----|------|-------------|
| method | ```string``` | HTTP method (GET, POST, PUT, etc.) |
| headers | ```array``` | Associative array of request headers |
| body | ```array or string ```	| Request payload. If an array is provided, it will be JSON-encoded automatically. |

## 🧠 Response Format

The callback receives a response array like:

```php
[
    'status' => 200,
    'data' => [...],       // Decoded JSON
    // 'error' => '...',    // Only if cURL fails
]
```

## 📄 License

MIT © php-fetch