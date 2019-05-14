<?php declare(strict_types=1);

namespace Gockets\Model;

/**
 * Channel object
 */
final class Channel
{
    private $publisherToken;

    private $subscriberToken;

    private $hookUrl;

    private $tag;

    private $listeners;

    public function __construct(
        string $publisherToken,
        string $subscriberToken,
        ?string $hookUrl = null,
        ?string $tag = null,
        int $listeners = 0
    ) {
        $this->publisherToken = $publisherToken;
        $this->subscriberToken = $subscriberToken;
        $this->hookUrl = $hookUrl;
        $this->tag = $tag;
        $this->listeners = $listeners;
    }

    public function getPublisherToken(): string
    {
        return $this->publisherToken;
    }

    public function getSubscriberToken(): string
    {
        return $this->subscriberToken;
    }

    public function getHookUrl(): ?string
    {
        return $this->hookUrl;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function getListeners(): int
    {
        return $this->listeners;
    }
}
