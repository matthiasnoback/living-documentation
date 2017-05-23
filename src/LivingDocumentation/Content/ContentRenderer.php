<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use LivingDocumentation\Node;

interface ContentRenderer
{
    public function render(Content $content, Node $node): string;
}
