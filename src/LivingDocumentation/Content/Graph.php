<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use Alom\Graphviz\Graph as GraphvizGraph;

final class Graph implements Content
{
    /**
     * @var GraphvizGraph
     */
    private $graph;

    public function __construct(GraphvizGraph $graph)
    {
        $this->graph = $graph;
    }

    public function graph(): GraphvizGraph
    {
        return $this->graph;
    }
}
