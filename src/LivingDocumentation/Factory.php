<?php
declare(strict_types=1);

namespace LivingDocumentation;

use Doctrine\Common\Annotations\AnnotationReader;
use LivingDocumentation\Content\Graph;
use LivingDocumentation\Content\GraphRenderer;
use LivingDocumentation\Content\PhpMarkdownParser;
use LivingDocumentation\Output\NodeRenderer;
use LivingDocumentation\Plugin\Application\ApplicationCollector;
use LivingDocumentation\Plugin\BoundedContext\BoundedContextCollector;
use LivingDocumentation\Content\DelegatingContentRenderer;
use LivingDocumentation\Content\MarkdownContentRenderer;
use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\MarkdownSnippet;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Content\NothingContentRenderer;
use LivingDocumentation\Output\SingleHtmlPageRenderer;
use LivingDocumentation\Plugin\Glossary\GlossaryCollector;
use LivingDocumentation\Plugin\Glossary\GlossaryEntry;
use LivingDocumentation\Plugin\Glossary\GlossaryEntryContentRenderer;
use LivingDocumentation\Plugin\HexagonalArchitecture\AdapterCollector;
use LivingDocumentation\Plugin\HexagonalArchitecture\PortCollector;
use LivingDocumentation\Plugin\HexagonalArchitecture\PortDiagramCollector;
use Michelf\Markdown;

final class Factory
{
    public static function createBuilder(): Builder
    {
        return new Builder([
            new ApplicationCollector(),
            new BoundedContextCollector(),
            new PortCollector(),
            new AdapterCollector(),
            new PortDiagramCollector(),
            new GlossaryCollector(new AnnotationReader()),
        ]);
    }

    public static function createRenderer(): NodeRenderer
    {
        $markdownParser = new PhpMarkdownParser(new Markdown());

        $markdownContentRenderer = new MarkdownContentRenderer($markdownParser);
        $contentRenderer = new DelegatingContentRenderer([
            Nothing::class => new NothingContentRenderer(),
            MarkdownFile::class => $markdownContentRenderer,
            MarkdownSnippet::class => $markdownContentRenderer,
            Graph::class => new GraphRenderer(),
            GlossaryEntry::class => new GlossaryEntryContentRenderer($markdownParser)
        ]);

        return new SingleHtmlPageRenderer($contentRenderer);
    }
}
