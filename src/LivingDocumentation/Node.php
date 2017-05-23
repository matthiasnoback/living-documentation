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
    private $path;

    /**
     * @var array|Content[]
     */
    private $content = [];

    /**
     * @var array|Node[]
     */
    private $childNodes = [];

    /**
     * @var Node|null
     */
    private $parent;

    public function __construct(string $path)
    {
        $this->path = rtrim($path, '/');
    }

    public function addContent(Content $content): void
    {
        $this->content[] = $content;
    }

    public function category(): string
    {
        return Inflector::pluralize($this->label());
    }

    public function path(): string
    {
        return $this->path;
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

    /**
     * @return array|Content[]
     */
    public function content(): array
    {
        return $this->content;
    }

    public function tag(): string
    {
        return ($this->parent instanceof Node ? $this->parent->tag() . '_' : '') . $this->fileNameWithoutExtension();
    }

    public function label(): string
    {
        return Inflector::ucwords($this->className());
    }

    public function title(): string
    {
        return Inflector::ucwords($this->fileNameWithoutExtension());
    }

    private function fileNameWithoutExtension()
    {
        return pathinfo($this->path, PATHINFO_FILENAME);
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

    public function findParentOfType(string $class): ?Node
    {
        if (!$this->parent instanceof Node) {
            return null;
        }

        return $this->parent instanceof $class ? $this->parent : $this->parent->findParentOfType($class);
    }
}
