<?php
declare(strict_types=1);

namespace LivingDocumentation;

use LivingDocumentation\Content\Nothing;

final class SourceRoot extends Node
{
    public function __construct($directory)
    {
        parent::__construct($directory, new Nothing());
    }
}
