<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use Michelf\Markdown;

final class PhpMarkdownParser implements MarkdownParser
{
    /**
     * @var Markdown
     */
    private $markdownParser;

    public function __construct(Markdown $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parse(string $markdown): string
    {
        return $this->markdownParser->transform($markdown);
    }
}
