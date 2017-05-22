<?php
declare(strict_types=1);

namespace LivingDocumentation\Output;

use LivingDocumentation\Content\Renderer;
use LivingDocumentation\Node;

/**
 * @todo use Twig
 */
final class SingleHtmlPageRenderer
{
    /**
     * @var Renderer
     */
    private $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function render(Node $rootNode): string
    {
        return strtr(file_get_contents(__DIR__ . '/layout.html'),
            [
                '{{ navigation }}' => $this->renderNavigation($rootNode),
                '{{ content }}' => $this->renderContent($rootNode)
            ]
        );
    }

    public function renderNavigation(Node $rootNode): string
    {
        $result = '';

        if (!$rootNode->hasChildren()) {
            return $result;
        }

        $result .= '<ul>';

        foreach ($rootNode->childrenGroupedByType() as $type => $childNodes) {
            $result .= '<li>';

            /** @var Node[] $childNodes */
            $firstChild = $childNodes[0];
            $result .= '<span class="category">' . $firstChild->category() . '</span>';

            $result .= '<ul>';

            foreach ($childNodes as $childNode) {
                $result .= '<li>';

                $anchor = $childNode->tag();

                $result .= '<a href="#' . $anchor . '">' . $childNode->title() . '</a>';

                $result .= $this->renderNavigation($childNode);

                $result .= '</li>';
            }

            $result .= '</ul>';

            $result .= '</li>';
        }

        $result .= '</ul>';

        return $result;
    }

    public function renderContent(Node $rootNode): string
    {
        $result = '';

        $result .= '<div class="' . $rootNode->label() . '">';

        $result .= '<a name="' . $rootNode->tag() . '"></a>';

        $result .= '<h1>' . $rootNode->title() . '</h1>';

        $result .= $this->renderer->render($rootNode->content());

        foreach ($rootNode->childrenGroupedByType() as $type => $childNodes) {
            /** @var Node[] $childNodes */
            $firstChild = $childNodes[0];
            $result .= '<div class="' . $firstChild->category() . '">';

            foreach ($childNodes as $childNode) {
                $result .= $this->renderContent($childNode);
            }

            $result .= '</div>';
        }

        $result .= '</div>';

        return $result;
    }
}
