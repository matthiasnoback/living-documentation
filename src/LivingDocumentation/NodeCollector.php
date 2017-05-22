<?php
declare(strict_types=1);

namespace LivingDocumentation;

interface NodeCollector
{
    /**
     * @param Node $node
     * @return array|Node[]
     */
    public function collect(Node $node): array;
}
