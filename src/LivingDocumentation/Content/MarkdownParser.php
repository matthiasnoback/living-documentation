<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

interface MarkdownParser
{
    /**
     * @param string $markdown
     * @return string HTML
     */
    public function parse(string $markdown): string;
}
