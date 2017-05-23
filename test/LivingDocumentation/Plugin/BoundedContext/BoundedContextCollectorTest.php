<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\BoundedContext;

use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Plugin\Application\Application;
use PHPUnit\Framework\TestCase;

final class BoundedContextCollectorTest extends TestCase
{
    /**
     * @test
     */
    public function it_collects_bounded_contexts_under_an_application_node(): void
    {
        $collector = new BoundedContextCollector();

        $result = $collector->collect(new Application(__DIR__ . '/Fixtures/src/Meetup', new Nothing()));

        $node1 = new BoundedContext(
            __DIR__ . '/Fixtures/src/Meetup/Identity'
        );
        $node2 = new BoundedContext(
            __DIR__ . '/Fixtures/src/Meetup/MeetupOrganizing'
        );
        $node2->addContent(new MarkdownFile(__DIR__ . '/Fixtures/src/Meetup/MeetupOrganizing/BoundedContext.md'));

        $this->assertEquals([$node1, $node2], $result);
    }
}
