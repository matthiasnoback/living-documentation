<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

final class MarkdownContentRenderer implements ContentRenderer
{
    /**
     * @var MarkdownParser
     */
    private $markdownParser;

    public function __construct(MarkdownParser $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function render(Content $content) : string
    {
        if ($content instanceof MarkdownFile) {
            $markdown = file_get_contents($content->filePath());
        } elseif ($content instanceof MarkdownSnippet) {
            $markdown = $content->text();
        } else {
            throw new \LogicException('Expected a MarkdownFile content');
        }

        return $this->markdownParser->parse($markdown);
    }
}
