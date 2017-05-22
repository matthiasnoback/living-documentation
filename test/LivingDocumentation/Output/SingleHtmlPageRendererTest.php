<?php

namespace LivingDocumentation\Output;

use Fixtures\Fixtures;
use LivingDocumentation\Builder;
use LivingDocumentation\Content\DelegatingRenderer;
use LivingDocumentation\Plugin\Application\ApplicationCollector;
use LivingDocumentation\Plugin\BoundedContext\BoundedContextCollector;
use PHPUnit\Framework\TestCase;

final class SingleHtmlPageRendererTest extends TestCase
{
    /**
     * @var Builder
     */
    private $builder;

    protected function setUp()
    {
        $this->builder = new Builder([
            new ApplicationCollector(),
            new BoundedContextCollector()
        ]);
    }

    /**
     * @test
     */
    public function it_renders_a_navigation_tree(): void
    {
        $node = $this->builder->buildNodeTree(Fixtures::dir() . '/src/');

        $renderer = new SingleHtmlPageRenderer(new DelegatingRenderer());

        $result = $renderer->renderNavigation($node);

        $this->assertRenderedHtmlEqualsFile(__DIR__ . '/Fixtures/navigation.html', $result);
    }

    /**
     * @test
     */
    public function it_renders_a_content_tree(): void
    {
        $node = $this->builder->buildNodeTree(Fixtures::dir() . '/src/');

        $renderer = new SingleHtmlPageRenderer(new DelegatingRenderer());

        $result = $renderer->renderContent($node);

        $this->assertRenderedHtmlEqualsFile(__DIR__ . '/Fixtures/content.html', $result);
    }

    private function assertRenderedHtmlEqualsFile(string $filePath, string $renderedHtml): void
    {
        $expectedDocument = new \DOMDocument(1.0);
        $actualDocument = new \DOMDocument(1.0);

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
