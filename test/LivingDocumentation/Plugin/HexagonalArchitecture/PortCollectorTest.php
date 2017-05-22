<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\HexagonalArchitecture;

use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Plugin\Application\Application;
use LivingDocumentation\Plugin\BoundedContext\BoundedContext;
use PHPUnit\Framework\TestCase;

final class PortCollectorTest extends TestCase
{
    /**
     * @test
     */
    public function it_collects_port_nodes()
    {
        $collector = new PortCollector();

        $result = $collector->collect(new BoundedContext(__DIR__ . '/Fixtures/BoundedContext', new Nothing()));

        $this->assertEquals(
            [
                new Port(__DIR__ . '/Fixtures/BoundedContext/Infrastructure/Notification', new Nothing()),
                new Port(__DIR__ . '/Fixtures/BoundedContext/Infrastructure/Persistence', new MarkdownFile(
                    __DIR__ . '/Fixtures/BoundedContext/Infrastructure/Persistence/Port.md'
                )),
            ],
            $result
        );
    }
}
