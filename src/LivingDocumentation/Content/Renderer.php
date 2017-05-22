<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

interface Renderer
{
    public function render(Content $content): string;
}
