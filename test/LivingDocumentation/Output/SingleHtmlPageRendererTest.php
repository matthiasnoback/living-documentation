<?php

namespace LivingDocumentation\Output;

use Fixtures\Fixtures;
use LivingDocumentation\Builder;
use LivingDocumentation\Content\DelegatingRenderer;
use PHPUnit\Framework\TestCase;

final class SingleHtmlPageRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_renders_a_tree_of_the_application(): void
    {
        $builder = new Builder();
        $node = $builder->buildNodeTree(Fixtures::dir() . '/src/');

        $renderer = new SingleHtmlPageRenderer(new DelegatingRenderer());

        $result = $renderer->render($node);

        $expected = <<<EOD
<h1>Meetup.nl</h1>

<p>A better Meetup.com.</p>
<h1>Meetup Organizing</h1>

EOD;

        $this->assertEquals($expected, $result);
    }
}
