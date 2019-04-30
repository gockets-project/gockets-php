<?php declare(strict_types=1);

namespace Tests\Gockets\Adapter;

use Gockets\Adapter\ChannelAdapter;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ChannelAdapterTest extends TestCase
{
    public function testConvertJson(): void
    {
        $adapter = new ChannelAdapter();
        $json = '{"publisher_token":"ce5c546376052619973c1c660e2790f7","subscriber_token":"6f682b85480508142b3d765bbec58ab1","subscriber_message_hook_url":"http://localhost/log.php","listeners":0}';

        $channel = $adapter->convertJson($json);

        Assert::assertEquals('ce5c546376052619973c1c660e2790f7', $channel->getPublisherToken());
        Assert::assertEquals('6f682b85480508142b3d765bbec58ab1', $channel->getSubscriberToken());
        Assert::assertEquals('http://localhost/log.php', $channel->getHookUrl());
        Assert::assertEquals(0, $channel->getListeners());
    }

    public function testConvertJsonArray(): void
    {
        $adapter = new ChannelAdapter();
        $json = '{"channels":[{"publisher_token":"ce5c546376052619973c1c660e2790f7","subscriber_token":"6f682b85480508142b3d765bbec58ab1","subscriber_message_hook_url":"http://localhost/log.php","listeners":0},{"publisher_token":"aa1690eff31903c4dd7d3cd4c034a3b1","subscriber_token":"b3303f4ea00913882a3fac3c893570af","subscriber_message_hook_url":"http://localhost/log2.php","listeners":0}]}';

        $channels = $adapter->convertJsonArray($json);

        Assert::assertEquals('aa1690eff31903c4dd7d3cd4c034a3b1', $channels[1]->getPublisherToken());
        Assert::assertEquals('b3303f4ea00913882a3fac3c893570af', $channels[1]->getSubscriberToken());
        Assert::assertEquals('http://localhost/log2.php', $channels[1]->getHookUrl());
        Assert::assertEquals(0, $channels[1]->getListeners());
    }
}
