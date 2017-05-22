<?php
declare(strict_types=1);

namespace Fixtures\src\Meetup\MeetupOrganizing\Domain;

use LivingDocumentation\Plugin\Glossary\Annotation\CoreConcept;

/**
 * A meetup is a get-together for people sharing some interest (like technology, marketing, or drinking).
 *
 * @CoreConcept()
 */
final class Meetup
{
    /**
     * Schedule a meetup
     *
     * @return Meetup
     */
    public static function schedule(): Meetup
    {
    }

    /**
     * Reschedule a meetup
     */
    public function reschedule(): void
    {
    }
}
