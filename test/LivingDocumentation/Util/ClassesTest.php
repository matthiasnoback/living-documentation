<?php
declare(strict_types=1);

namespace LivingDocumentation\Util;

use LivingDocumentation\Util\Fixtures\SomeClass;
use LivingDocumentation\Util\Fixtures\SubNamespace\SomeOtherClass;
use PHPUnit\Framework\TestCase;

final class ClassesTest extends TestCase
{
    /**
     * @test
     * @dataProvider classAndNamespaceProvider
     */
    public function it_knows_if_a_class_is_inside_a_given_namespace(
        string $className,
        string $namespaceName,
        bool $classIsExpectedToBeWithinNamespace
    ) {
        $this->assertSame($classIsExpectedToBeWithinNamespace, Classes::isClassWithinNamespace($className, $namespaceName));
    }

    public function classAndNamespaceProvider(): array
    {
        $someClassReflectionClass = new \ReflectionClass(SomeClass::class);
        $someOtherReflectionClass = new \ReflectionClass(SomeOtherClass::class);

        return [
            [
                $someClassReflectionClass->getName(),
                $someClassReflectionClass->getNamespaceName(),
                true
            ],
            [
                $someOtherReflectionClass->getName(),
                $someClassReflectionClass->getNamespaceName(),
                true
            ],
            [
                $someClassReflectionClass->getName(),
                $someOtherReflectionClass->getNamespaceName(),
                false
            ]
        ];
    }

    /**
     * @test
     */
    public function it_knows_the_short_name_of_a_class()
    {
        $this->assertEquals('SomeClass', Classes::shortName(SomeClass::class));
        $this->assertEquals('DateTime', Classes::shortName(\DateTime::class));
    }
}
