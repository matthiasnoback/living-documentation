<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\Glossary;

use LivingDocumentation\Plugin\Glossary\Fixtures\MeetupOrganizing\Domain\Meetup;
use PHPUnit\Framework\TestCase;

final class CoreConceptTest extends TestCase
{
    /**
     * @test
     */
    public function its_title_is_the_class_name()
    {
        $node = new CoreConcept(__DIR__ . '/Fixtures/MeetupOrganizing/Domain/Meetup.php', new GlossaryEntry(Meetup::class));
        $this->assertEquals('Meetup', $node->title());
    }
}
