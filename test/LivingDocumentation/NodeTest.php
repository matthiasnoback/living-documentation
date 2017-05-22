<?php

namespace LivingDocumentation;

use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Fixtures\SomeNodeType;
use LivingDocumentation\Fixtures\SomeOtherNodeType;
use PHPUnit\Framework\TestCase;

final class NodeTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_return_children_grouped_by_type()
    {
        $child1 = new SomeNodeType();
        $child2 = new SomeOtherNodeType();

        $node = $this->createSomeNode();
        $node->addChildren([$child1, $child2]);

        $this->assertEquals(
            [
                get_class($child1) => [$child1],
                get_class($child2) => [$child2]
            ],

            $node->childrenGroupedByType());
    }

    private function createSomeNode(): Node
    {
        return new Node(__DIR__, new Nothing());
    }
}
