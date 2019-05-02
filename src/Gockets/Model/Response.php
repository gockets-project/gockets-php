<?php declare(strict_types=1);

namespace Gockets\Model;

/**
 * Basic server response
 */
final class Response
{
    private $success;

    private $type;

    private $message;

    public function __construct(string $type, string $message)
    {
        $this->success = $type !== 'ERR';
        $this->type = $type;
        $this->message = $message;
    }


    public function getSuccess(): ?bool
    {
        return $this->success;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
