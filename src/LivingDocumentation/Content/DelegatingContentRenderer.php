<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use LivingDocumentation\Node;

final class DelegatingContentRenderer implements ContentRenderer
{
    /**
     * @var array|ContentRenderer[]
     */
    private $renderers;

    /**
     * @param array|ContentRenderer[] $renderers
     */
    public function __construct(array $renderers)
    {
        $this->renderers = $renderers;
    }

    public function render(Content $content, Node $node): string
    {
        if (!isset($this->renderers[get_class($content)])) {
            throw new \LogicException('No renderer known for content class');
        }

        $renderer = $this->renderers[get_class($content)];

        return $renderer->render($content, $node);
    }
}
