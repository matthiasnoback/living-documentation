<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\Glossary;

use LivingDocumentation\Content\PhpMarkdownParser;
use LivingDocumentation\Node;
use LivingDocumentation\Plugin\Glossary\Fixtures\MeetupOrganizing\Domain\Meetup;
use Michelf\Markdown;
use PHPUnit\Framework\TestCase;

final class GlossaryEntryRendererTest extends TestCase
{
    /**
     * @test
     */
    public function it_renders_a_markdown_transformed_description_for_each_glossary_entry()
    {
        $expectedHtml = <<<EOD
<p>A meetup is a get-together for people sharing some interest (like technology, marketing, or drinking).</p>
EOD;

        $content = new GlossaryEntry(Meetup::class);
        $renderer = new GlossaryEntryContentRenderer(new PhpMarkdownParser(new Markdown()));
        $renderer->render($content, $this->createMock(Node::class));

        $this->assertEquals(
            trim($expectedHtml),
            trim($renderer->render($content, $this->createMock(Node::class)))
        );
    }
}
