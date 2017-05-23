<?php
declare(strict_types=1);

namespace LivingDocumentation\Content;

use LivingDocumentation\Node;
use Symfony\Component\Process\Process;

final class GraphRenderer implements ContentRenderer
{
    public function render(Content $content, Node $node): string
    {
        if (!$content instanceof Graph) {
            throw new \LogicException('Expected $content to be of type Graph');
        }

        $graph = $content->graph();

        $dotInstructions = $graph->render();

        $process = new Process('dot -T svg');
        $process->setInput($dotInstructions);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException('Failed to execute "dot"');
        }

        $svg = $process->getOutput();

        $encodedSvg = base64_encode($svg);

        $html = '<img src="data:image/svg+xml;base64,' . $encodedSvg . '">';

        file_put_contents(__DIR__ .'/test.html', $html);

        return $html;
    }
}
