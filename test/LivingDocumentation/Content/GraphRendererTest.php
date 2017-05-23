<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use Alom\Graphviz\Digraph;
use LivingDocumentation\Node;
use PHPUnit\Framework\TestCase;

final class GraphRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_renders_a_graph_as_svg()
    {
       $graph = new Digraph('G');
       $graph->node('A');
       $graph->node('B');
       $graph->edge(['A', 'B']);

       $graphRenderer = new GraphRenderer();
       $result = $graphRenderer->render(new Graph($graph), $this->createMock(Node::class));

       // TODO probably quite brittle ;)
       $this->assertEquals('<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIKICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPgo8IS0tIEdlbmVyYXRlZCBieSBncmFwaHZpeiB2ZXJzaW9uIDIuMzguMCAoMjAxNDA0MTMuMjA0MSkKIC0tPgo8IS0tIFRpdGxlOiBHIFBhZ2VzOiAxIC0tPgo8c3ZnIHdpZHRoPSI2MnB0IiBoZWlnaHQ9IjExNnB0Igogdmlld0JveD0iMC4wMCAwLjAwIDYyLjAwIDExNi4wMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+CjxnIGlkPSJncmFwaDAiIGNsYXNzPSJncmFwaCIgdHJhbnNmb3JtPSJzY2FsZSgxIDEpIHJvdGF0ZSgwKSB0cmFuc2xhdGUoNCAxMTIpIj4KPHRpdGxlPkc8L3RpdGxlPgo8cG9seWdvbiBmaWxsPSJ3aGl0ZSIgc3Ryb2tlPSJub25lIiBwb2ludHM9Ii00LDQgLTQsLTExMiA1OCwtMTEyIDU4LDQgLTQsNCIvPgo8IS0tIEEgLS0+CjxnIGlkPSJub2RlMSIgY2xhc3M9Im5vZGUiPjx0aXRsZT5BPC90aXRsZT4KPGVsbGlwc2UgZmlsbD0ibm9uZSIgc3Ryb2tlPSJibGFjayIgY3g9IjI3IiBjeT0iLTkwIiByeD0iMjciIHJ5PSIxOCIvPgo8dGV4dCB0ZXh0LWFuY2hvcj0ibWlkZGxlIiB4PSIyNyIgeT0iLTg1LjgiIGZvbnQtZmFtaWx5PSJUaW1lcyxzZXJpZiIgZm9udC1zaXplPSIxNC4wMCI+QTwvdGV4dD4KPC9nPgo8IS0tIEIgLS0+CjxnIGlkPSJub2RlMiIgY2xhc3M9Im5vZGUiPjx0aXRsZT5CPC90aXRsZT4KPGVsbGlwc2UgZmlsbD0ibm9uZSIgc3Ryb2tlPSJibGFjayIgY3g9IjI3IiBjeT0iLTE4IiByeD0iMjciIHJ5PSIxOCIvPgo8dGV4dCB0ZXh0LWFuY2hvcj0ibWlkZGxlIiB4PSIyNyIgeT0iLTEzLjgiIGZvbnQtZmFtaWx5PSJUaW1lcyxzZXJpZiIgZm9udC1zaXplPSIxNC4wMCI+QjwvdGV4dD4KPC9nPgo8IS0tIEEmIzQ1OyZndDtCIC0tPgo8ZyBpZD0iZWRnZTEiIGNsYXNzPSJlZGdlIj48dGl0bGU+QSYjNDU7Jmd0O0I8L3RpdGxlPgo8cGF0aCBmaWxsPSJub25lIiBzdHJva2U9ImJsYWNrIiBkPSJNMjcsLTcxLjY5NjZDMjcsLTYzLjk4MjcgMjcsLTU0LjcxMjUgMjcsLTQ2LjExMjQiLz4KPHBvbHlnb24gZmlsbD0iYmxhY2siIHN0cm9rZT0iYmxhY2siIHBvaW50cz0iMzAuNTAwMSwtNDYuMTA0MyAyNywtMzYuMTA0MyAyMy41MDAxLC00Ni4xMDQ0IDMwLjUwMDEsLTQ2LjEwNDMiLz4KPC9nPgo8L2c+Cjwvc3ZnPgo=">', $result);
    }
}
