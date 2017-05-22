<?php
declare(strict_types=1);

namespace LivingDocumentation;

use LivingDocumentation\Plugin\Application\ApplicationCollector;
use LivingDocumentation\Plugin\BoundedContext\BoundedContextCollector;

final class Builder
{
    /**
     * @var array|NodeCollector[]
     */
    private $collectors;

    /**
     * @param array|NodeCollector[] $collectors
     */
    public function __construct(array $collectors)
    {
        $this->collectors = $collectors;
    }

    public function buildNodeTree(string $srcDirectory): Node
    {
        $sourceRoot = new SourceRoot($srcDirectory);

        $loopOverNodes = [$sourceRoot];

        foreach ($this->collectors as $collector) {
            $collectedNodes = [];
            foreach ($loopOverNodes as $node) {
                $childNodes = $collector->collect($node);
                $node->addChildren($childNodes);
                $collectedNodes = array_merge($collectedNodes, $childNodes);
            }

            $loopOverNodes = $collectedNodes;
        }

        return $sourceRoot;
    }
}
