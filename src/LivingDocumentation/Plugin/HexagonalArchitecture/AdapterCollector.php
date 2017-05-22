<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\HexagonalArchitecture;

use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Node;
use LivingDocumentation\NodeCollector;

final class AdapterCollector implements NodeCollector
{
    public function collect(Node $node): array
    {
        if (!$node instanceof Port) {
            return [];
        }

        $adapterDirectories = glob($node->path() . '/**/', GLOB_ONLYDIR);

        return array_map([$this, 'mapDirectoryToAdapterNode'], $adapterDirectories);
    }

    private function mapDirectoryToAdapterNode(string $directory): Adapter
    {
        return new Adapter($directory, new Nothing());
    }
}
