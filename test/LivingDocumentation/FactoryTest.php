<?php
declare(strict_types=1);

namespace LivingDocumentation;

use Fixtures\Fixtures;
use PHPUnit\Framework\TestCase;

final class FactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_working_builder_and_renderer()
    {
        $builder = Factory::createBuilder();

        $node = $builder->buildNodeTree(Fixtures::dir() . '/src/');

        $nodeRenderer = Factory::createRenderer();

        $result = $nodeRenderer->render($node);

        $this->assertNotEmpty($result);
    }
}
