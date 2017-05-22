<?php
declare(strict_types=1);

namespace LivingDocumentation;

use Doctrine\Common\Inflector\Inflector;
use LivingDocumentation\Content\Content;

class Node
{
    /**
     * @var string
     */
    private $directory;

    /**
     * @var Content
     */
    private $content;

    /**
     * @var array|Node[]
     */
    private $childNodes = [];

    /**
     * @var Node|null
     */
    private $parent;

    public function __construct(string $directory, Content $content)
    {
        $this->directory = rtrim($directory, '/');
        $this->content = $content;
    }

    public function category(): string
    {
        return Inflector::pluralize($this->label());
    }

    public function directory()
    {
        return $this->directory;
    }

    /**
     * @todo make Node immutable
     * @param Node $child
     */
    public function addChild(Node $child): void
    {
        $this->childNodes[] = $child;
        $child->parent = $this;
    }

    /**
     * @todo make Node immutable
     * @param array $children
     */
    public function addChildren(array $children): void
    {
        foreach ($children as $child) {
            $this->addChild($child);
        }
    }

    /**
     * @return array|Node[]
     */
    public function childNodes(): array
    {
        return $this->childNodes;
    }

    public function content(): Content
    {
        return $this->content;
    }

    public function tag(): string
    {
        return ($this->parent instanceof Node ? $this->parent->tag() . '_' : '') . $this->dirName();
    }

    public function label(): string
    {
        return Inflector::ucwords($this->className());
    }

    public function title(): string
    {
        return Inflector::ucwords($this->dirName());
    }

    private function dirName()
    {
        return basename($this->directory);
    }

    private function className()
    {
        $parts = explode('\\', get_class($this));

        return end($parts);
    }

    public function childrenGroupedByType(): array
    {
        $result = [];

        foreach ($this->childNodes as $childNode) {
            $result[get_class($childNode)][] = $childNode;
        }

        return $result;
    }

    public function hasChildren(): bool
    {
        return count($this->childNodes) > 0;
    }
}
