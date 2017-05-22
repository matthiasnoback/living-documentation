<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

final class DelegatingRenderer implements Renderer
{
    /**
     * @var array|Renderer[]
     */
    private $renderers;

    public function __construct()
    {
        $this->renderers = [
            MarkdownFile::class => new MarkdownFileRenderer(),
            Nothing::class => new NothingRenderer()
        ];
    }

    public function render(Content $content): string
    {
        if (!isset($this->renderers[get_class($content)])) {
            throw new \LogicException('No renderer known for content class');
        }

        $renderer = $this->renderers[get_class($content)];

        return $renderer->render($content);
    }
}
