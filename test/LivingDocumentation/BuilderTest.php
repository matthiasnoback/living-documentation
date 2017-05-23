<?php
declare(strict_types=1);

namespace LivingDocumentation;

use Fixtures\Fixtures;
use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Plugin\Application\Application;
use LivingDocumentation\Plugin\Application\ApplicationCollector;
use LivingDocumentation\Plugin\BoundedContext\BoundedContext;
use LivingDocumentation\Plugin\BoundedContext\BoundedContextCollector;
use PHPUnit\Framework\TestCase;

final class BuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_builds_the_correct_node_tree()
    {
        $builder = new Builder([
            new ApplicationCollector(),
            new BoundedContextCollector()
        ]);

        $result = $builder->buildNodeTree(Fixtures::dir() . '/src/');

        $expectedSourceRoot = new SourceRoot(Fixtures::dir() . '/src/');

        $meetupNode = new Application(Fixtures::dir() . '/src/Meetup');
        $meetupNode->addContent(new MarkdownFile(Fixtures::dir() . '/src/Meetup/Application.md'));
        $identityNode = new BoundedContext(Fixtures::dir() . '/src/Meetup/Identity');
        $meetupNode->addChild($identityNode);
        $meetupOrganizingNode = new BoundedContext(Fixtures::dir() . '/src/Meetup/MeetupOrganizing');
        $meetupOrganizingNode->addContent(new MarkdownFile(Fixtures::dir() . '/src/Meetup/MeetupOrganizing/BoundedContext.md'));
        $meetupNode->addChild($meetupOrganizingNode);

        $imageProcessorNode = new Application(Fixtures::dir() . '/src/ImageProcessor');
        $expectedSourceRoot->addChild($imageProcessorNode);

        $expectedSourceRoot->addChild($meetupNode);

        $this->assertEquals($expectedSourceRoot, $result);
    }
}
