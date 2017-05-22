<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

final class NothingRenderer implements Renderer
{
    public function render(Content $content): string
    {
        return '';
    }
}
