<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\BoundedContext;

use LivingDocumentation\Content\Content;
use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Node;
use LivingDocumentation\NodeCollector;
use LivingDocumentation\Plugin\Application\Application;

final class BoundedContextCollector implements NodeCollector
{
    public function collect(Node $node): array
    {
        if (!$node instanceof Application) {
            return [];
        }

        $boundedContextDirectories = glob($node->path() . '/*/', GLOB_ONLYDIR);

        return array_map([$this, 'mapToBoundedContextNodes'], $boundedContextDirectories);
    }

    private function mapToBoundedContextNodes(string $directory): BoundedContext
    {
        $node = new BoundedContext($directory);

        $this->addContent($node, $directory);

        return $node;
    }

    private function addContent(BoundedContext $node, string $directory): void
    {
        $markdownFile = $directory . '/BoundedContext.md';
        if (is_file($markdownFile)) {
            $node->addContent(new MarkdownFile(realpath($markdownFile)));
        }
    }
}
