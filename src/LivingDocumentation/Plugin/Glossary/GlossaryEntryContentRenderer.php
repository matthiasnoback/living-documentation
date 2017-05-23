<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\Glossary;

use LivingDocumentation\Content\Content;
use LivingDocumentation\Content\ContentRenderer;
use LivingDocumentation\Content\MarkdownParser;
use LivingDocumentation\Node;
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

    /**
     * @todo: check if $node is still required/justifiable here
     *
     * @param Content $content
     * @param Node $node
     * @return string
     */
    public function render(Content $content, Node $node): string
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
