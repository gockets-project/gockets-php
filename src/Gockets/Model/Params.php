<?php declare(strict_types=1);

namespace Gockets\Model;

/**
 * Params for HTTP client
 *
 * @package Gockets\Model
 * @author Artem Zakharchenko <artz.relax@gmail.com>
 */
final class Params
{
    private $host;

    private $port;

    public function __construct(string $host = 'localhost', string $port = '8844')
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): string
    {
        return $this->port;
    }
}
