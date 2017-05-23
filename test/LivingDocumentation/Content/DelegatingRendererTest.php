<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use LivingDocumentation\Node;
use PHPUnit\Framework\TestCase;

final class DelegatingRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_delegates_to_the_appropriate_renderer()
    {
        $content = $this->createMock(Content::class);
        $contentRenderer = $this->createMock(ContentRenderer::class);
        $renderedContent = 'The rendered content';
        $contentRenderer
            ->expects($this->any())
            ->method('render')
            ->with($this->identicalTo($content))
            ->will($this->returnValue($renderedContent));
        $delegatingContentRenderer = new DelegatingContentRenderer([
            get_class($content) => $contentRenderer,
            'SomeOtherContentClass' => $this->createMock(ContentRenderer::class)
        ]);

        $result = $delegatingContentRenderer->render($content, $this->createMock(Node::class));

        $this->assertEquals($renderedContent, $result);
    }
}
