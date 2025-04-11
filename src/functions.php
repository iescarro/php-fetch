<?php

/**
 * Sends an HTTP request to the specified URL using cURL.
 *
 * @param string $url The URL to send the request to.
 * @param array $options An associative array of options for the request:
 *     - 'method' (string): The HTTP method to use (e.g., 'GET', 'POST', etc.). Defaults to 'GET'.
 *     - 'headers' (array): An associative array of headers to include in the request.
 *     - 'body' (mixed): The body of the request. Can be a string or an array (which will be JSON-encoded).
 * @param callable|null $callback An optional callback function to handle the response. The callback will receive an
 *     associative array with the following keys:
 *     - 'status' (int): The HTTP status code of the response.
 *     - 'data' (mixed): The decoded JSON response data, or null if decoding fails.
 *     - 'error' (string): An error message if the request fails, or null if successful.
 *
 * @return void
 */

namespace PhpFetch;

function fetch($url, $options = [], $callback = null)
{
    $method = strtoupper($options['method'] ?? 'GET');
    $headers = $options['headers'] ?? [];
    $body = $options['body'] ?? null;

    $ch = curl_init($url);

    // Set method
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
    } elseif ($method !== 'GET') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    }

    // Set body
    if ($body !== null) {
        if (is_array($body)) {
            $body = json_encode($body);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    }

    // Set headers
    $formattedHeaders = [];
    foreach ($headers as $key => $value) {
        $formattedHeaders[] = "$key: $value";
    }
    if (!empty($formattedHeaders)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $formattedHeaders);
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $error = curl_error($ch);
        if ($callback) {
            $callback(['error' => $error, 'status' => $httpCode, 'data' => null]);
        }
    } else {
        $decoded = json_decode($response, true);
        if ($callback) {
            $callback(['status' => $httpCode, 'data' => $decoded]);
        }
    }

    curl_close($ch);
}
