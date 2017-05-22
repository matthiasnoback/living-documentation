<?php
declare(strict_types=1);

namespace LivingDocumentation;

use LivingDocumentation\Plugin\Application\ApplicationCollector;
use LivingDocumentation\Plugin\BoundedContexts\BoundedContextsCollector;

final class Builder
{
    /**
     * @var array|NodeCollector[]
     */
    private $collectors;

    public function __construct()
    {
        $this->collectors = [
            new ApplicationCollector(),
            new BoundedContextsCollector()
        ];
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
