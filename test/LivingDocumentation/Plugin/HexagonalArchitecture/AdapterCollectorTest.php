<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\HexagonalArchitecture;

use LivingDocumentation\Content\Nothing;
use PHPUnit\Framework\TestCase;

final class AdapterCollectorTest extends TestCase
{
    /**
     * @test
     */
    public function it_collects_port_nodes()
    {
        $collector = new AdapterCollector();

        $result = $collector->collect(new Port(__DIR__ . '/Fixtures/BoundedContext/Infrastructure/Persistence', new Nothing()));

        $this->assertEquals(
            [
                new Adapter(__DIR__ . '/Fixtures/BoundedContext/Infrastructure/Persistence/InMemory', new Nothing()),
                new Adapter(__DIR__ . '/Fixtures/BoundedContext/Infrastructure/Persistence/MySQL', new Nothing()),
            ],
            $result
        );
    }
}
