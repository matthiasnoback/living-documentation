<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\Glossary;

use LivingDocumentation\Content\Content;
use LivingDocumentation\Content\ContentRenderer;
use LivingDocumentation\Content\MarkdownParser;
use phpDocumentor\Reflection\DocBlock;

final class GlossaryEntryContentRenderer implements ContentRenderer
{
    /**
     * @var MarkdownParser
     */
    private $markdownParser;

    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function render(Content $content): string
    {
        if (!$content instanceof GlossaryEntry) {
            throw new \LogicException('Expected $content to be of type GlossaryEntry');
        }

        $reflectionClass = new \ReflectionClass($content->className());

        $docBlock = new DocBlock($reflectionClass);

        $markdown = $docBlock->getShortDescription() . $docBlock->getLongDescription()->getContents();

        return $this->markdownParser->parse($markdown);
    }
}
