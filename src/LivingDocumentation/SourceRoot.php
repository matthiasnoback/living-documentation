<?php
declare(strict_types=1);

namespace LivingDocumentation;

use LivingDocumentation\Content\Nothing;

final class SourceRoot extends Node
{
    public function __construct($path)
    {
        parent::__construct($path, new Nothing());
    }

    public function title(): string
    {
        return 'Source root';
    }
}
