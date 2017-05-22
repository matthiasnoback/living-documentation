<?php

require __DIR__ . '/../vendor/autoload.php';

$node = (new \LivingDocumentation\Builder([
    new \LivingDocumentation\Plugin\Application\ApplicationCollector(),
    new \LivingDocumentation\Plugin\BoundedContext\BoundedContextCollector()
]))->buildNodeTree(\Fixtures\Fixtures::dir() . '/src/');

$contentRenderer = new \LivingDocumentation\Content\DelegatingRenderer();
$renderer = new \LivingDocumentation\Output\SingleHtmlPageRenderer($contentRenderer);

echo $renderer->render($node);
