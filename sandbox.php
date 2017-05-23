<?php
declare(strict_types=1);

use Fixtures\Fixtures;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Plugin\BoundedContext\BoundedContext;
use LivingDocumentation\Plugin\HexagonalArchitecture\Adapter;
use LivingDocumentation\Plugin\HexagonalArchitecture\Port;
use LivingDocumentation\Util\Classes;
use LivingDocumentation\Util\Files;

require __DIR__ . '/bootstrap.php';

$boundedContext = new BoundedContext(
    Fixtures::dir() . '/src/Meetup/MeetupOrganizing',
    new Nothing()
);
$port = new Port(
    Fixtures::dir() . '/src/Meetup/MeetupOrganizing/Infrastructure/Persistence',
    new Nothing()
);
$mysqlAdapter = new Adapter(
    Fixtures::dir() . '/src/Meetup/MeetupOrganizing/Infrastructure/Persistence/MySQL',
    new Nothing()
);
$inMemoryAdapter = new Adapter(
    Fixtures::dir() . '/src/Meetup/MeetupOrganizing/Infrastructure/Persistence/InMemory',
    new Nothing()
);
$port->addChildren([$mysqlAdapter, $inMemoryAdapter]);
$boundedContext->addChild($port);

$coreInterfaces = [];
$adapterImplements = [];
$boundedContextDirectory = $boundedContext->path();
$portDirectory = $port->path();
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
            $interfaceDirectory = dirname($reflectionInterface->getFileName());
            if (Files::isPathWithinInDirectory($reflectionInterface->getFileName(), $boundedContextDirectory)) {
                $coreInterfaces[$reflectionInterface->getName()] = $reflectionInterface->getName();
                $adapterImplements[$reflectionInterface->getName()][] = [$childNode, $adapterClass];
                // interface is within this bounded context
                //echo 'Adapter class ' . $adapterClass . ' implements core interface ' . $reflectionInterface->getName() . "\n";
            }
        }
    }
}

$graph = new Alom\Graphviz\Digraph('H');
$graph->attr('graph', ['label' => $port->title() . ' port']);
$graph->attr('node', ['shape' => 'box']);

foreach ($coreInterfaces as $coreInterface) {
    $interfaceNode = $graph->beginNode(md5($coreInterface), ['label' => Classes::shortName($coreInterface), 'style' => 'dashed']);
    foreach ($adapterImplements[$coreInterface] as [$adapter, $adapterClass]) {
        /** @var $adapter Adapter */
        $adapterSubGraph = $graph->subgraph('cluster_' . $adapter->tag());
        $adapterSubGraph->attr('graph', ['label' => $adapter->title() . ' adapter']);
        $adapterSubGraph->attr('node', ['shape' => 'box']);
        $adapterNode = $adapterSubGraph->beginNode(md5($adapterClass), ['label' => Classes::shortName($adapterClass)]);
        $graph->edge([$adapterNode->getId(), $interfaceNode->getId()], ['style' => 'dashed', 'arrowhead' => 'empty']);
    }
}

echo $graph->render();
