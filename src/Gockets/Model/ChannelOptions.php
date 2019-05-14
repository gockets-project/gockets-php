<?php declare(strict_types=1);

namespace Gockets\Model;

/**
 * Channel options object to be sent on channel prepare
 */
final class ChannelOptions
{
    private $hookUrl;

    private $tag;

    public function __construct(?string $hookUrl, ?string $tag)
    {
        $this->hookUrl = $hookUrl;
        $this->tag = $tag;
    }

    public function getHookUrl(): ?string
    {
        return $this->hookUrl;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }
}
