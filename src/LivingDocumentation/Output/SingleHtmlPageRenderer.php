<?php
declare(strict_types=1);

namespace LivingDocumentation\Output;

use LivingDocumentation\Content\Renderer;
use LivingDocumentation\Node;

final class SingleHtmlPageRenderer
{
    /**
     * @var Renderer
     */
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render(Node $node): string
    {
        $result = '';

        $result .= $this->renderer->render($node->content());

        foreach ($node->childNodes() as $childNode) {
            $result .= $this->render($childNode);
        }

        return $result;
    }
}
