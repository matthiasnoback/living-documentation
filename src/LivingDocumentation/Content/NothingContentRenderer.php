<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use LivingDocumentation\Node;

final class NothingContentRenderer implements ContentRenderer
{
    public function render(Content $content, Node $node): string
    {
        return '';
    }
}
