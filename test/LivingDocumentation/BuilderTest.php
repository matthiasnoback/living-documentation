<?php

namespace LivingDocumentation;

use Fixtures\Fixtures;
use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Plugin\Application\Application;
use LivingDocumentation\Plugin\BoundedContexts\BoundedContext;
use PHPUnit\Framework\TestCase;

final class BuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_correct_node_tree()
    {
        $builder = new Builder();

        $result = $builder->buildNodeTree(Fixtures::dir() . '/src/');

        $expectedSourceRoot = new SourceRoot(Fixtures::dir() . '/src/');
        $meetupApplication = new Application(
            Fixtures::dir() . '/src/Meetup',
            new MarkdownFile(Fixtures::dir() . '/src/Meetup/Application.md')
        );
        $meetupApplication->addChild(
            new BoundedContext(Fixtures::dir() . '/src/Meetup/Identity', new Nothing())
        );
        $meetupApplication->addChild(
            new BoundedContext(
                Fixtures::dir() . '/src/Meetup/MeetupOrganizing',
                new MarkdownFile(Fixtures::dir() . '/src/Meetup/MeetupOrganizing/BoundedContext.md')
            )
        );
        $imageProcessorApplication = new Application(
            Fixtures::dir() . '/src/ImageProcessor',
            new Nothing()
        );
        $expectedSourceRoot->addChild($imageProcessorApplication);

        $expectedSourceRoot->addChild($meetupApplication);

        $this->assertEquals($expectedSourceRoot, $result);
    }
}
