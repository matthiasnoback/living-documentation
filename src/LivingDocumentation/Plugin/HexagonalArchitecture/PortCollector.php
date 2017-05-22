<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\HexagonalArchitecture;

use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Node;
use LivingDocumentation\NodeCollector;
use LivingDocumentation\Plugin\BoundedContext\BoundedContext;

final class PortCollector implements NodeCollector
{
    public function collect(Node $node): array
    {
        if (!$node instanceof BoundedContext) {
            return [];
        }

        $portDirectories = glob($node->path() . '/Infrastructure/**', GLOB_ONLYDIR);

        return array_map([$this, 'mapPortDirectoryToPortNode'], $portDirectories);
    }

    private function mapPortDirectoryToPortNode(string $directory): Port
    {
        $markdownFile = $directory . '/Port.md';
        if (is_file($markdownFile)) {
            $content = new MarkdownFile($markdownFile);
        } else {
            $content = new Nothing();
        }

        return new Port($directory, $content);
    }
}
