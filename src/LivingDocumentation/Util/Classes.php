<?php
declare(strict_types=1);

namespace LivingDocumentation\Util;

use BetterReflection\Reflection\ReflectionClass;
use BetterReflection\Reflector\ClassReflector;
use BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;

final class Classes
{
    /**
     * @param string $directory
     * @return array|string[]
     */
    static public function findWithinDirectory(string $directory): array
    {
        $singleDirectorySourceLocator = new DirectoriesSourceLocator([$directory]);
        $reflector = new ClassReflector($singleDirectorySourceLocator);

        $reflectionClasses = $reflector->getAllClasses();

        $classNames = array_map(function (ReflectionClass $reflectionClass) {
            return $reflectionClass->getName();
        }, $reflectionClasses);

        return $classNames;
    }

    public static function isClassWithinNamespace($className, $namespaceName): bool
    {
        $className = trim($className, '\\');
        $namespaceName = trim($namespaceName, '\\') . '\\';

        return strpos($className, $namespaceName) === 0;
    }

    public static function shortName(string $className): string
    {
        $parts = explode('\\', $className);
        return end($parts);
    }
}
