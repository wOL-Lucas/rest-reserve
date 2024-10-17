<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;

function filterHeaders($headers) {
    $allowedHeaders = ['accept', 'content-type'];

    return array_filter($headers, function($key) use ($allowedHeaders) {
        return in_array(strtolower($key), $allowedHeaders);
    }, ARRAY_FILTER_USE_KEY);
}

function decodeJwtToken($token, $secretKey) {
    try {
        return JWT::decode($token, new Key($secretKey, 'HS256'));
    } catch (Exception $e) {
        return null;
    }
}

Route::any(
    '/user/{path}',
    function(Request $request, $path) {
        $client = new HttpClient([
            'base_uri' => 'http://localhost:8081'
        ]);

        $resp = $client->request(
            $request->method(),
            $path,
            [
                'headers' => filterHeaders($request->header()),
                'query' => $request->query(),
                'body' => $request->getContent()
            ]
        );

        return response(
            $resp
                ->getBody()
                ->getContents(),
            $resp
                ->getStatusCode()
        )->withHeaders(
            filterHeaders($resp->getHeaders())
        );
    }
)->where('path', '.*');

