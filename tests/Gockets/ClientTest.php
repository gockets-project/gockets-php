<?php declare(strict_types=1);

namespace Tests\Gockets;

use Gockets\Client;
use Gockets\Exception\ChannelNotFoundException;
use Gockets\Model\Channel;
use Gockets\Model\Params;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ClientTest extends TestCase
{
    use GocketsProcessTrait;

    /** @var Client */
    private static $client;

    public static function setUpBeforeClass(): void
    {
        if (self::isRunningOnLinux()) {
            self::executeInBackground(__DIR__ . '/../../bin/main');
            self::$client = new Client(new Params());
        }
    }

    protected function setUp(): void
    {
        if (!self::isRunningOnLinux()) {
            $this->markTestSkipped('Currently tests running on Linux only.');
        }
    }

    public static function tearDownAfterClass(): void
    {
        if (self::isRunningOnLinux()) {
            exec('kill -9 ' . self::$processPid);
        }
    }

    public function testChannelPrepare(): Channel
    {
        $channel = self::$client->prepare('domain.com');

        Assert::assertNotEmpty($channel->getPublisherToken());
        Assert::assertNotEmpty($channel->getSubscriberToken());
        Assert::assertEquals('domain.com', $channel->getHookUrl());
        Assert::assertEquals(0, $channel->getListeners());

        return $channel;
    }

    /**
     * @depends testChannelPrepare
     */
    public function testShowChannel(Channel $channel): void
    {
        $channelCheck = self::$client->show($channel->getPublisherToken());

        Assert::assertEquals($channel, $channelCheck);
    }

    /**
     * @depends testChannelPrepare
     */
    public function testShowAll(Channel $channel): void
    {
        $channels = self::$client->showAll();

        Assert::assertCount(1, $channels);
        Assert::assertEquals($channel, $channels[0]);
    }

    /**
     * @depends testChannelPrepare
     */
    public function testPublish(Channel $channel): void
    {
        $data = [
            'data' => 'content',
        ];

        $response = self::$client->publish($data, $channel->getPublisherToken());

        Assert::assertTrue($response->getSuccess());
        Assert::assertEquals('INF', $response->getType());
        Assert::assertNotEmpty($response->getMessage());
    }

    /**
     * @depends testChannelPrepare
     */
    public function testClose(Channel $channel): Channel
    {
        $response = self::$client->close($channel->getPublisherToken());

        Assert::assertTrue($response->getSuccess());
        Assert::assertEquals('OK', $response->getType());
        Assert::assertNotEmpty($response->getMessage());

        return $channel;
    }

    /**
     * @depends testClose
     */
    public function testThrowsChannelNotFoundException(Channel $channel): void
    {
        $this->expectException(ChannelNotFoundException::class);

        self::$client->show($channel->getPublisherToken());
    }

    public function testChannelPrepareWithoutHook(): void
    {
        $channel = self::$client->prepare();

        Assert::assertNotEmpty($channel->getPublisherToken());
        Assert::assertNotEmpty($channel->getSubscriberToken());
        Assert::assertNull($channel->getHookUrl());
        Assert::assertEquals(0, $channel->getListeners());
    }

    public function testPushDataToNotExistingChannel(): void
    {
        $data = [
            'data' => 'content',
        ];

        try {
            self::$client->publish($data, 'some-not-existing-publisher-token');
        } catch (ChannelNotFoundException $exception) {
            $response = $exception->getResponse();

            Assert::assertFalse($response->getSuccess());
            Assert::assertEquals('ERR', $response->getType());
            Assert::assertNotEmpty($response->getMessage());
        }
    }

    public function testCloseNotExistingChannel(): void
    {
        try {
            self::$client->close('some-not-existing-publisher-token');
        } catch (ChannelNotFoundException $exception) {
            $response = $exception->getResponse();

            Assert::assertFalse($response->getSuccess());
            Assert::assertEquals('ERR', $response->getType());
            Assert::assertNotEmpty($response->getMessage());
        }
    }
}
