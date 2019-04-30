<?php declare(strict_types=1);

namespace Tests\Gockets\Adapter;

use Gockets\Adapter\ResponseAdapter;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

final class ResponseAdapterTest extends TestCase
{
    public function testConvertJson(): void
    {
        $adapter = new ResponseAdapter();
        $json = '{"type":"OK","message":"Successfully closed connection"}';

        $response = $adapter->convertJson($json);

        Assert::assertTrue($response->getSuccess());
        Assert::assertEquals('OK', $response->getType());
        Assert::assertEquals('Successfully closed connection', $response->getMessage());
    }

    public function testConvertJsonArray(): void
    {
        $adapter = new ResponseAdapter();
        $json = '{"type":"OK","message":"Successfully closed connection"}';

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Unsupported operation');

        $adapter->convertJsonArray($json);
    }
}
