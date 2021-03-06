<?php
declare(strict_types=1);

namespace LivingDocumentation\Fixtures;

use LivingDocumentation\Content\Nothing;
use LivingDocumentation\Node;

final class SomeOtherNodeType extends Node
{
    public function __construct()
    {
        parent::__construct('');
    }
}
