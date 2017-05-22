<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\BoundedContexts;

use LivingDocumentation\Content\Content;
use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Node;
use LivingDocumentation\NodeCollector;
use LivingDocumentation\Plugin\Application\Application;

final class BoundedContextsCollector implements NodeCollector
{
    public function collect(Node $node): array
    {
        if (!$node instanceof Application) {
            return [];
        }

        $boundedContextDirectories = glob($node->directory() . '/*/', GLOB_ONLYDIR);

        return array_map([$this, 'mapToBoundedContextNodes'], $boundedContextDirectories);
    }

    private function mapToBoundedContextNodes(string $directory): BoundedContext
    {
        return new BoundedContext($directory, $this->createContent($directory));
    }

    private function createContent(string $directory): Content
    {
        $markdownFile = $directory . '/BoundedContext.md';
        if (is_file($markdownFile)) {
            return new MarkdownFile(realpath($markdownFile));
        }

        return new Nothing();
    }
}
