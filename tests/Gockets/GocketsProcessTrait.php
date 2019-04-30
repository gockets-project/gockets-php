<?php declare(strict_types=1);

namespace Tests\Gockets;

trait GocketsProcessTrait
{
    /** @var int Gockets process PID */
    private static $processPid;

    private static function executeInBackground($script): void
    {
        $output = null;
        exec($script . ' > /dev/null 2>&1 & echo $!', $output);

        self::$processPid = (int) $output[0];
    }

    private static function isRunningOnLinux(): bool
    {
        return php_uname('s') === 'Linux';
    }
}
