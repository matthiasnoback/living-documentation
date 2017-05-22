<?php

namespace LivingDocumentation\Content;

use PHPUnit\Framework\TestCase;

final class DelegatingRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_delegates_to_the_appropriate_renderer()
    {
        $renderer = new DelegatingRenderer();

        $result = $renderer->render(new MarkdownFile(__DIR__ . '/Fixtures/dummy.md'));

        $this->assertEquals('<h1>Dummy</h1>', trim($result));
    }
}
