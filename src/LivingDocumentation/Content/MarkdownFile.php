<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

final class MarkdownFile implements Content
{
    /**
     * @var string
     */
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function filePath(): string
    {
        return $this->filePath;
    }
}
