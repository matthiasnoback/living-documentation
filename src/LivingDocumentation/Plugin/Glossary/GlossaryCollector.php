<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\Glossary;

use BetterReflection\Reflection\ReflectionClass;
use BetterReflection\Reflector\ClassReflector;
use BetterReflection\SourceLocator\Type\DirectoriesSourceLocator;
use Doctrine\Common\Annotations\Reader;
use LivingDocumentation\Node;
use LivingDocumentation\NodeCollector;
use LivingDocumentation\Plugin\BoundedContext\BoundedContext;
use LivingDocumentation\Plugin\Glossary\Annotation\CoreConcept as CoreConceptAnnotation;

final class GlossaryCollector implements NodeCollector
{
    /**
     * @var Reader
     */
    private $annotationReader;

    public function __construct(Reader $annotationReader)
    {
        $this->annotationReader = $annotationReader;
    }

    /**
     * @todo we should not simply reject non-BoundedContext nodes, since the project using this plugin might not have them
     */
    public function collect(Node $node): array
    {
        if (!$node instanceof BoundedContext) {
            return [];
        }

        $directory = $node->path();
        $classNames = $this->findAllClassNamesWithinDirectory($directory);

        $newNodes = [];

        foreach ($classNames as $className) {
            $reflectionClass = new \ReflectionClass($className);
            $coreConceptAnnotation = $this->annotationReader->getClassAnnotation(
                $reflectionClass,
                CoreConceptAnnotation::class
            );
            if ($coreConceptAnnotation === null) {
                continue;
            }

            $newNodes[] = new CoreConcept($reflectionClass->getFileName(), new GlossaryEntry($className));
        }

        return $newNodes;
    }

    /**
     * @param string $directory
     * @return array|string[]
     */
    private function findAllClassNamesWithinDirectory(string $directory): array
    {
        $singleDirectorySourceLocator = new DirectoriesSourceLocator([$directory]);
        $reflector = new ClassReflector($singleDirectorySourceLocator);

        $reflectionClasses = $reflector->getAllClasses();

        $classNames = array_map(function (ReflectionClass $reflectionClass) {
            return $reflectionClass->getName();
        }, $reflectionClasses);

        return $classNames;
    }
}
