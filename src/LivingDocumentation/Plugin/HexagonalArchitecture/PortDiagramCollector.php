<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\HexagonalArchitecture;

use Alom\Graphviz\Digraph;
use LivingDocumentation\Content\Graph;
use LivingDocumentation\Node;
use LivingDocumentation\NodeCollector;
use LivingDocumentation\Plugin\BoundedContext\BoundedContext;
use LivingDocumentation\Util\Classes;
use LivingDocumentation\Util\Files;

final class PortDiagramCollector implements NodeCollector
{
    public function collect(Node $node): array
    {
        if (!$node instanceof Port) {
            return [];
        }

        $content = new Graph($this->buildGraph($node));

        $node->addContent($content);

        return [];
    }

    private function buildGraph(Port $port)
    {
        $boundedContext = $port->findParentOfType(BoundedContext::class);
        if (!$boundedContext instanceof BoundedContext) {
            throw new \LogicException('Port node was expected to have an ancestor of type BoundedContext');
        }

        $coreInterfaces = [];
        $adapterImplements = [];
        $boundedContextDirectory = $boundedContext->path();
        foreach ($port->childNodes() as $childNode) {
            if (!$childNode instanceof Adapter) {
                // skip non-Adapter nodes
                continue;
            }

            /** @var $childNode Adapter */
            $adapterDir = $childNode->path();
            $adapterClasses = Classes::findWithinDirectory($adapterDir);
            foreach ($adapterClasses as $adapterClass) {
                $reflectionClass = new \ReflectionClass($adapterClass);
                foreach ($reflectionClass->getInterfaces() as $reflectionInterface) {
                    if (Classes::isClassWithinNamespace($reflectionInterface->getName(), $reflectionClass->getNamespaceName())) {
                        // skip interfaces within adapter namespace
                        continue;
                    }
                    if (Files::isPathWithinInDirectory($reflectionInterface->getFileName(), $boundedContextDirectory)) {
                        // interface is within this bounded context
                        $coreInterfaces[$reflectionInterface->getName()] = $reflectionInterface->getName();
                        $adapterImplements[$reflectionInterface->getName()][] = [$childNode, $adapterClass];
                    }
                }
            }
        }

        $graph = new Digraph('H');
        $graph->attr('graph', ['label' => $port->title() . ' port']);
        $graph->attr('node', ['shape' => 'box', 'margin' => '0.3,0.2']);

        foreach ($coreInterfaces as $coreInterface) {
            $interfaceNode = $graph->beginNode(md5($coreInterface), ['label' => Classes::shortName($coreInterface), 'style' => 'dashed']);
            foreach ($adapterImplements[$coreInterface] as [$adapter, $adapterClass]) {
                /** @var $adapter Adapter */
                $adapterSubGraph = $graph->subgraph('cluster_' . $adapter->tag());
                $adapterSubGraph->attr('graph', ['label' => $adapter->title() . ' adapter', 'style' => 'filled', 'fillcolor' => 'gray89']);
                $adapterSubGraph->attr('node', ['shape' => 'box', 'style' => 'filled', 'fillcolor' => 'white']);
                $adapterNode = $adapterSubGraph->beginNode(md5($adapterClass), ['label' => Classes::shortName($adapterClass)]);
                $graph->edge([$adapterNode->getId(), $interfaceNode->getId()], ['style' => 'dashed', 'arrowhead' => 'empty']);
            }
        }

        return $graph;
    }
}
