<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

final class NothingContentRenderer implements ContentRenderer
{
    public function render(Content $content): string
    {
        return '';
    }
}
