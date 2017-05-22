<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\Glossary;

use Doctrine\Common\Annotations\AnnotationReader;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Plugin\BoundedContext\BoundedContext;
use LivingDocumentation\Plugin\Glossary\Fixtures\MeetupOrganizing\Domain\Meetup;
use PHPUnit\Framework\TestCase;

final class GlossaryCollectorTest extends TestCase
{
    /**
     * @test
     */
    public function it_collects_core_concepts_from_a_bounded_context()
    {
        $collector = new GlossaryCollector( new AnnotationReader());

        $result = $collector->collect(new BoundedContext(__DIR__ . '/Fixtures/MeetupOrganizing', new Nothing()));

        $this->assertEquals([
            new CoreConcept(Meetup::filePath(), new GlossaryEntry(Meetup::class))
        ], $result);
    }
}
