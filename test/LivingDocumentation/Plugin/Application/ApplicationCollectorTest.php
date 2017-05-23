<?php
declare(strict_types=1);

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

        $node1 = new Application(__DIR__ . '/Fixtures/src/ImageProcessor');
        $node2 = new Application(__DIR__ . '/Fixtures/src/Meetup');
        $node2->addContent(new MarkdownFile(__DIR__ . '/Fixtures/src/Meetup/Application.md'));

        $this->assertEquals([$node1, $node2], $result);
    }
}
