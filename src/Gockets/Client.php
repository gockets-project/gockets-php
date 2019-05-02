<?php declare(strict_types=1);

namespace Gockets;

use Gockets\Adapter\ChannelAdapter;
use Gockets\Adapter\ResponseAdapter;
use Gockets\Contract\AdapterInterface;
use Gockets\Contract\GocketsInterface;
use Gockets\Exception\ChannelNotFoundException;
use Gockets\Factory\HttpFactory;
use Gockets\Model\Channel;
use Gockets\Model\Params;
use Gockets\Model\Response;

/**
 * Gockets Client
 *
 * Implements available Gockets methods.
 *
 * @package Gockets
 */
class Client implements GocketsInterface
{
    /**
     * Help to convert json into defined Channel objects.
     *
     * @var AdapterInterface
     */
    private $channelAdapter;

    /**
     * Help to convert json into defined Response objects.
     *
     * @var AdapterInterface
     */
    private $responseAdapter;

    /**
     * HTTP client to communicate with daemon.
     *
     * @var \GuzzleHttp\Client
     */
    private static $http;

    public function __construct(Params $params)
    {
        $this->channelAdapter = new ChannelAdapter();
        $this->responseAdapter = new ResponseAdapter();
        self::$http = HttpFactory::createHttpClient($params);
    }

    public function prepare(?string $hookUrl = null): Channel
    {
        if (is_null($hookUrl)) {
            $options = [];
        } else {
            $options = [
                \GuzzleHttp\RequestOptions::JSON => [
                    'subscriber_message_hook_url' => $hookUrl,
                ],
            ];
        }

        $result = self::$http->post('channel/prepare', $options);

        return $this->channelAdapter->convertJson($result->getBody()->getContents());
    }

    public function show(string $publisherToken): Channel
    {
        $result = self::$http->get("channel/{$publisherToken}");

        if ($result->getStatusCode() === 404) {
            throw new ChannelNotFoundException($result->getBody()->getContents());
        }

        return $this->channelAdapter->convertJson($result->getBody()->getContents());
    }

    public function showAll(): array
    {
        $result = self::$http->get('channel');

        return $this->channelAdapter->convertJsonArray($result->getBody()->getContents());
    }

    public function publish($data, string $publisherToken): Response
    {
        $result = self::$http->post("channel/publish/{$publisherToken}", [
            \GuzzleHttp\RequestOptions::JSON => $data,
        ]);

        if ($result->getStatusCode() === 404) {
            throw new ChannelNotFoundException($result->getBody()->getContents());
        }

        return $this->responseAdapter->convertJson($result->getBody()->getContents());
    }

    public function close(string $publisherToken): Response
    {
        $result = self::$http->delete("channel/publish/{$publisherToken}");

        if ($result->getStatusCode() === 404) {
            throw new ChannelNotFoundException($result->getBody()->getContents());
        }

        return $this->responseAdapter->convertJson($result->getBody()->getContents());
    }
}
