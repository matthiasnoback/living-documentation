<?php
declare(strict_types=1);

namespace LivingDocumentation\Plugin\HexagonalArchitecture\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class Port
{
    public $name;

    public function __construct(array $data)
    {
        if (isset($data['name'])) {
            $name = $data['name'];
        } elseif (isset($data['value'])) {
            $name = $data['value'];
        } else {
            throw new \LogicException('Provide a port name, e.g. @Port(name="Persistence") or @Port("Persistence")');
        }

        $this->name = $name;
    }
}
