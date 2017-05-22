<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

final class MarkdownSnippet implements Content
{
    /**
     * @var string
     */
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function text(): string
    {
        return $this->text;
    }
}
