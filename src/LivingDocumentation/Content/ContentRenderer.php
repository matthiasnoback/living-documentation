<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

interface ContentRenderer
{
    public function render(Content $content): string;
}
