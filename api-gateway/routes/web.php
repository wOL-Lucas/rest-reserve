<?php

use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

function filterHeaders($headers) {
    $allowedHeaders = ['accept', 'content-type'];

    return array_filter($headers, function($key) use ($allowedHeaders) {
        return in_array(strtolower($key), $allowedHeaders);
    }, ARRAY_FILTER_USE_KEY);
}

Route::any(
    '/user/{path}',
    function(Request $request, $path) {
        try {
            $client = new HttpClient([
                // send to the user service container
                'base_uri' => 'user-service',
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
        } catch (GuzzleException $e) {
            echo $e->getMessage();
        }
    }
)->where('path', '.*');

