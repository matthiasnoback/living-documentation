<?php

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

        $this->assertEquals([
            new BoundedContext(
                __DIR__ . '/Fixtures/src/Meetup/Identity',
                new Nothing()
            ),
            new BoundedContext(
                __DIR__ . '/Fixtures/src/Meetup/MeetupOrganizing',
                new MarkdownFile(__DIR__ . '/Fixtures/src/Meetup/MeetupOrganizing/BoundedContext.md')
            ),
        ], $result);
    }
}
