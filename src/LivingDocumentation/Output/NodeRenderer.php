<?php
declare(strict_types=1);

namespace LivingDocumentation\Output;

use LivingDocumentation\Node;

interface NodeRenderer
{
    public function render(Node $rootNode): string;
}
