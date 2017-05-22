<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\Application;

use LivingDocumentation\Content\Content;
use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Node;
use LivingDocumentation\NodeCollector;
use LivingDocumentation\SourceRoot;

final class ApplicationCollector implements NodeCollector
{
    public function collect(Node $node): array
    {
        if (!$node instanceof SourceRoot) {
            return [];
        }

        $applicationDirectories = glob($node->path() . '/*/', GLOB_ONLYDIR);

        return array_map([$this, 'mapToApplicationNodes'], $applicationDirectories);
    }

    private function mapToApplicationNodes(string $applicationDirectory): Application
    {
        return new Application(
            $applicationDirectory,
            $this->createContent($applicationDirectory)
        );
    }

    private function createContent(string $applicationDirectory): Content
    {
        $markdownFilePath = $applicationDirectory . '/Application.md';
        if (is_file($markdownFilePath)) {
            return new MarkdownFile(realpath($markdownFilePath));
        }

        return new Nothing();
    }
}
