<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Data;

/**
 * Class Property.
 *
 * @package   RichId\CsvGeneratorBundle\Data
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class Property
{
    /** @var string */
    protected $name;

    /** @var \ReflectionProperty */
    protected $reflectionProperty;

    private function __construct()
    {
    }

    public static function build(string $name, \ReflectionProperty $property): self
    {
        $object = new static();

        $object->name = $name;
        $object->reflectionProperty = $property;

        return $object;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReflectionProperty(): \ReflectionProperty
    {
        return $this->reflectionProperty;
    }
}
