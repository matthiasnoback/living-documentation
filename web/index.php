<?php

use Fixtures\Fixtures;
use LivingDocumentation\Factory;

require __DIR__ . '/../bootstrap.php';

$node = Factory::createBuilder()->buildNodeTree(Fixtures::dir() . '/src/');
$renderer = Factory::createRenderer();

echo $renderer->render($node);
