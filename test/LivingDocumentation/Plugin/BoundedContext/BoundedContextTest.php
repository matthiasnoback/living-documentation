<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\BoundedContext;

use LivingDocumentation\Content\Nothing;
use PHPUnit\Framework\TestCase;

final class BoundedContextTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_the_correct_label_and_title()
    {
        $boundedContext = new BoundedContext(__DIR__ . '/Fixtures/src/Meetup/MeetupOrganizing', new Nothing());
        $this->assertEquals('MeetupOrganizing', $boundedContext->title());
        $this->assertEquals('MeetupOrganizing', $boundedContext->tag());
        $this->assertEquals('BoundedContext', $boundedContext->label());
    }
}
