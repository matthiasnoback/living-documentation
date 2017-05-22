<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\Glossary;

use LivingDocumentation\Content\Content;

final class GlossaryEntry implements Content
{
    /**
     * @var string
     */
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function className(): string
    {
        return $this->className;
    }
}
