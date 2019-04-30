<?php declare(strict_types=1);

namespace Gockets\Exception;

use Gockets\Model\Response;
use Throwable;

/**
 * Basic library exception
 *
 * @package Gockets\Exception
 */
class GocketsException extends \Exception
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * GocketsException constructor.
     *
     * @param $response string The original json response
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $response, string $message = '', $code = 0, Throwable $previous = null)
    {
        $this->makeResponse($response);

        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    protected function makeResponse($content): void
    {
        $response = json_decode($content);

        $this->response = new Response($response->type, $response->message);
    }
}
