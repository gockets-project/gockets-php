<?php declare(strict_types=1);

namespace Gockets\Model;

/**
 * Channel object
 *
 * @package Gockets\Model
 * @author Artem Zakharchenko <artz.relax@gmail.com>
 */
final class Channel
{
    private $publisherToken;

    private $subscriberToken;

    private $hookUrl;

    private $listeners;

    public function __construct(string $publisherToken, string $subscriberToken, ?string $hookUrl = null, int $listeners = 0)
    {
        $this->publisherToken = $publisherToken;
        $this->subscriberToken = $subscriberToken;
        $this->hookUrl = $hookUrl;
        $this->listeners = $listeners;
    }

    public function getPublisherToken(): string
    {
        return $this->publisherToken;
    }

    public function setPublisherToken(string $publisherToken): void
    {
        $this->publisherToken = $publisherToken;
    }

    public function getSubscriberToken(): string
    {
        return $this->subscriberToken;
    }

    public function setSubscriberToken(string $subscriberToken): void
    {
        $this->subscriberToken = $subscriberToken;
    }

    public function getHookUrl(): string
    {
        return $this->hookUrl;
    }

    public function setHookUrl(string $hookUrl): void
    {
        $this->hookUrl = $hookUrl;
    }

    public function getListeners(): int
    {
        return $this->listeners;
    }

    public function setListeners(int $listeners): void
    {
        $this->listeners = $listeners;
    }
}
