<?php declare(strict_types=1);

namespace Gockets\Adapter;

use Gockets\Contract\AdapterInterface;
use Gockets\Model\Response;

final class ResponseAdapter implements AdapterInterface
{
    /**
     * @param string $content
     * @return Response
     */
    public function convertJson(string $content): Response
    {
        $response = json_decode($content);

        return new Response($response->type, $response->message);
    }

    public function convertJsonArray(string $content): array
    {
        throw new \LogicException('Unsupported operation');
    }
}
