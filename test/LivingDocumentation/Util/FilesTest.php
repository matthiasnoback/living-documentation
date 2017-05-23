<?php
declare(strict_types=1);

namespace LivingDocumentation\Util;

use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    /**
     * @test
     * @dataProvider pathAndDirectoryProvider
     */
    public function it_can_tell_if_a_file_is_in_a_directory(string $path, string $directory, bool $pathIsExpectedToBeWithinDirectory)
    {
        $this->assertEquals($pathIsExpectedToBeWithinDirectory, Files::isPathWithinInDirectory($path, $directory));
    }

    public function pathAndDirectoryProvider(): array
    {
        return [
            [
                __FILE__,
                __DIR__,
                true
            ],
            [
                __DIR__,
                __FILE__,
                false
            ]
        ];
    }
}
