<?php declare(strict_types=1);

namespace Gockets\Factory;

use Gockets\Model\Params;
use GuzzleHttp\Client as HttpClient;

/**
 * Http Client Factory
 *
 * Responsible for creating instance of HTTP client.
 */
class HttpFactory
{
    public static function createHttpClient(Params $params): HttpClient
    {
        $baseUri = "{$params->getHost()}:{$params->getPort()}/";

        // Communications through JSON
        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        return new \GuzzleHttp\Client([
            'base_uri' => $baseUri,
            'defaults' => [
                'headers' => $headers,
            ],
            'http_errors' => false,
        ]);
    }
}
