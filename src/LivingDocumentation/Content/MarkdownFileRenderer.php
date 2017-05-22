<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use Michelf\Markdown;

final class MarkdownFileRenderer implements Renderer
{
    public function render(Content $content) : string
    {
        if (!$content instanceof MarkdownFile) {
            throw new \LogicException('Expected a MarkdownFile content');
        }

        return Markdown::defaultTransform(file_get_contents($content->filePath()));
    }
}
