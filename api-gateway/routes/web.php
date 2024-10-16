<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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

Route::any('/user/{path}', function(Request $request, $path) {
    $client = new HttpClient([
        'base_uri' => 'http://localhost:8081'
    ]);

    $authHeader = $request->header('Authorization');
    $jwtToken = null;
    if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $jwtToken = $matches[1];
    }

    $decodedToken = null;
    if ($jwtToken) {
        $secretKey = 'SQhFmQSdTAhurda37LJCvtvnbcKfzpdPJzSu9cMXnG0MNCCAYWU0XQxWdUigFyC7'; // Substitua pelo seu segredo
        $decodedToken = decodeJwtToken($jwtToken, $secretKey);
        Log::info('Decoded JWT Token:', (array) $decodedToken);

        if ($decodedToken && isset($decodedToken->roles) && $decodedToken->roles !== 'user') {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
    }

    $openPaths = ['register', 'login'];

    if (!in_array($path, $openPaths)) {
        return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }

    $resp = $client->request($request->method(), $path, [
        'headers' => filterHeaders($request->header()),
        'query' => $request->query(),
        'body' => $request->getContent(),
    ]);

    return response($resp->getBody()->getContents(), $resp->getStatusCode())
        ->withHeaders(filterHeaders($resp->getHeaders()));

})->where('path', '.*');

