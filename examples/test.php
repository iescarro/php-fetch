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
