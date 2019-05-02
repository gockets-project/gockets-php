<?php declare(strict_types=1);

namespace Gockets\Adapter;

use Gockets\Contract\AdapterInterface;
use Gockets\Model\Channel;
use stdClass;

/**
 * Channel Adapter
 *
 * Converts raw json into Channel object.
 */
final class ChannelAdapter implements AdapterInterface
{
    /**
     * @param string $content
     * @return Channel
     */
    public function convertJson(string $content): Channel
    {
        $channel = json_decode($content);

        return $this->stdClassToChannel($channel);
    }

    /**
     * @param string $content
     * @return array|Channel[]
     */
    public function convertJsonArray(string $content): array
    {
        $response = json_decode($content);

        $array = [];

        if (!empty($response->channels)) {
            foreach ($response->channels as $channel) {
                $array[] = $this->stdClassToChannel($channel);
            }
        }

        return $array;
    }

    /**
     * @param stdClass $channel
     * @return Channel
     */
    private function stdClassToChannel(stdClass $channel): Channel
    {
        return new Channel(
            $channel->publisher_token,
            $channel->subscriber_token,
            $channel->subscriber_message_hook_url,
            $channel->listeners
        );
    }
}
