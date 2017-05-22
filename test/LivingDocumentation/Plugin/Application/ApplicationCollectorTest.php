<?php

namespace LivingDocumentation\Plugin\Application;

use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\SourceRoot;
use PHPUnit\Framework\TestCase;

final class ApplicationCollectorTest extends TestCase
{
    /**
     * @test
     */
    public function it_collects_the_directories_directly_under_source_roots()
    {
        $collector = new ApplicationCollector();

        $result = $collector->collect(new SourceRoot(__DIR__ . '/Fixtures/src'));

        $this->assertEquals(
            [
                new Application(
                    __DIR__ . '/Fixtures/src/ImageProcessor',
                    new Nothing()
                ),
                new Application(
                    __DIR__ . '/Fixtures/src/Meetup',
                    new MarkdownFile(__DIR__ . '/Fixtures/src/Meetup/Application.md')
                )
            ],
            $result
        );
    }
}
