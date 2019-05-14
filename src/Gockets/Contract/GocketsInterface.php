<?php declare(strict_types=1);

namespace Gockets\Contract;

use Gockets\Exception\ChannelNotFoundException;
use Gockets\Model\Channel;
use Gockets\Model\ChannelOptions;
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
     * @param ChannelOptions|null $channelOptions
     * @return Channel
     */
    public function prepare(?ChannelOptions $channelOptions = null): Channel;

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
     * Edit specific channel (change hook url or tag).
     *
     * @param string $publisherToken Publisher token of channel to update
     * @param ChannelOptions $channelOptions
     * @return Channel
     */
    public function edit(string $publisherToken, ChannelOptions $channelOptions): Channel;

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
