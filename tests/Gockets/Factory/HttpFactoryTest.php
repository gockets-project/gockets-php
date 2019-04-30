<?php declare(strict_types=1);

namespace Tests\Gockets\Factory;

use Gockets\Factory\HttpFactory;
use Gockets\Model\Params;
use GuzzleHttp\Client as GuzzleHttpClient;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class HttpFactoryTest extends TestCase
{
    public function testCreateHttpClient(): void
    {
        $params = new Params('localhost', '8844');

        $httpClient = HttpFactory::createHttpClient($params);

        Assert::assertInstanceOf(GuzzleHttpClient::class, $httpClient);

        $config = $httpClient->getConfig();

        Assert::assertEquals('localhost', $config['base_uri']->getHost());
        Assert::assertEquals('8844', $config['base_uri']->getPort());

        Assert::assertEquals([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ], $config['defaults']['headers']);

        Assert::assertFalse($config['http_errors']);
    }
}
