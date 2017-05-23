<?php
declare(strict_types=1);

namespace LivingDocumentation\Util;

final class Files
{
    public static function isPathWithinInDirectory(string $path, string $directory): bool
    {
        $path = realpath($path);
        $directory = realpath($directory);

        return strpos($path, $directory) === 0;
    }
}
