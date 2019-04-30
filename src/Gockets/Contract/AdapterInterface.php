<?php declare(strict_types=1);

namespace Gockets\Contract;

/**
 * Adapter Interface
 *
 * Describes helper methods for converting json raw objects to defined class object.
 *
 * @package Gockets\Contract
 * @author Artem Zakharchenko <artz.relax@gmail.com>
 */
interface AdapterInterface
{
    /**
     * Convert JSON raw object to defined class object.
     *
     * @param string $content
     * @return mixed
     */
    public function convertJson(string $content);

    /**
     * Convert array of JSON raw objects to array of defined class objects.
     *
     * @param string $content
     * @return array
     */
    public function convertJsonArray(string $content): array;
}
