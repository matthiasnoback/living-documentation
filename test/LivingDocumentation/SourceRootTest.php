<?php
declare(strict_types=1);

namespace LivingDocumentation;

use PHPUnit\Framework\TestCase;

final class SourceRootTest extends TestCase
{
    /**
     * @test
     */
    public function its_title_is_source_root()
    {
        $node = new SourceRoot(__DIR__);
        $this->assertEquals('Source root', $node->title());
    }
}
