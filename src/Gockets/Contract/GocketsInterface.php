<?php declare(strict_types=1);

namespace Gockets\Contract;

use Gockets\Exception\ChannelNotFoundException;
use Gockets\Model\Channel;
use Gockets\Model\Response;

/**
 * Gockets Interface
 *
 * Describes available Gockets methods.
 */
interface GocketsInterface
{
    /**
     * Prepares channel with specifyed (optionally) hook URL.
     *
     * @param string|null $hookUrl
     * @return Channel
     */
    public function prepare(?string $hookUrl = null): Channel;

    /**
     * Get specific channel.
     *
     * @param string $publisherToken
     * @return Channel
     * @throws ChannelNotFoundException
     */
    public function show(string $publisherToken): Channel;

    /**
     * List of all channels.
     *
     * @return array|Channel[]
     */
    public function showAll(): array;

    /**
     * Pushes data to a Websocket connection passed in body of request.
     *
     * @param $data
     * @param string $publisherToken
     * @return Response
     * @throws ChannelNotFoundException
     */
    public function publish($data, string $publisherToken): Response;

    /**
     * Closes all Websocket connection to channel specified and deletes channel itself.
     *
     * @param string $publisherToken
     * @return Response
     * @throws ChannelNotFoundException
     */
    public function close(string $publisherToken): Response;
}
