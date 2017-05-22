<?php
declare(strict_types=1);

namespace LivingDocumentation\Output;

use Fixtures\Fixtures;
use LivingDocumentation\Builder;
use LivingDocumentation\Content\DelegatingContentRenderer;
use LivingDocumentation\Content\MarkdownFile;
use LivingDocumentation\Content\MarkdownContentRenderer;
use LivingDocumentation\Content\MarkdownSnippet;
use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Content\NothingContentRenderer;
use LivingDocumentation\Content\PhpMarkdownParser;
use LivingDocumentation\Plugin\Application\ApplicationCollector;
use LivingDocumentation\Plugin\BoundedContext\BoundedContextCollector;
use Michelf\Markdown;
use PHPUnit\Framework\TestCase;

final class SingleHtmlPageRendererTest extends TestCase
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * @var SingleHtmlPageRenderer
     */
    private $renderer;

    protected function setUp()
    {
        $this->builder = new Builder([
            new ApplicationCollector(),
            new BoundedContextCollector()
        ]);

        $markdownRenderer = new MarkdownContentRenderer(new PhpMarkdownParser(new Markdown()));

        $contentRenderer = new DelegatingContentRenderer(
            [
                MarkdownFile::class => $markdownRenderer,
                MarkdownSnippet::class => $markdownRenderer,
                Nothing::class => new NothingContentRenderer()
            ]
        );

        $this->renderer = new SingleHtmlPageRenderer($contentRenderer);
    }

    /**
     * @test
     */
    public function it_renders_a_navigation_tree(): void
    {
        $node = $this->builder->buildNodeTree(Fixtures::dir() . '/src/');

        $result = $this->renderer->renderNavigation($node);

        $this->assertRenderedHtmlEqualsFile(__DIR__ . '/Fixtures/navigation.html', $result);
    }

    /**
     * @test
     */
    public function it_renders_a_content_tree(): void
    {
        $node = $this->builder->buildNodeTree(Fixtures::dir() . '/src/');

        $result = $this->renderer->renderContent($node);

        $this->assertRenderedHtmlEqualsFile(__DIR__ . '/Fixtures/content.html', $result);
    }

    private function assertRenderedHtmlEqualsFile(string $filePath, string $renderedHtml): void
    {
        $expectedDocument = new \DOMDocument('1.0');
        $actualDocument = new \DOMDocument('1.0');

        $expectedDocument->preserveWhiteSpace = false;
        $actualDocument->preserveWhiteSpace = false;

        $expectedDocument->formatOutput = true;
        $actualDocument->formatOutput = true;

        $expectedDocument->loadXML(file_get_contents($filePath));
        $actualDocument->loadXML($renderedHtml);

        $expectedString = $expectedDocument->saveXML();
        $actualString = $actualDocument->saveXML();

        $this->assertEquals($expectedString, $actualString);
    }
}
