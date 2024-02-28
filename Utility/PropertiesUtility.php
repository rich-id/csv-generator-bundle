<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Utility;

use RichId\CsvGeneratorBundle\Attribute\CsvContentTranslationPrefix;
use RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Data\Property;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class PropertiesUtility.
 *
 * @package   RichId\CsvGeneratorBundle\Helper
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
final class PropertiesUtility
{
    protected NormalizerInterface $normalizer;

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    public function getPropertiesNamesForConfig(AbstractCsvGeneratorConfiguration $configuration): array
    {
        $class = new \ReflectionClass($configuration->getClass());
        $object = $class->newInstanceWithoutConstructor();

        return $this->getPropertiesName($configuration, $object);
    }

    public function getPropertiesForConfig(AbstractCsvGeneratorConfiguration $configuration): array
    {
        $properties = [];
        $class = new \ReflectionClass($configuration->getClass());
        $object = $class->newInstanceWithoutConstructor();

        $propertiesName = $this->getPropertiesName($configuration, $object);

        foreach ($class->getProperties() as $objectProperty) {
            if (!\in_array($objectProperty->getName(), $propertiesName, true)) {
                continue;
            }

            $properties[] = Property::build($objectProperty->getName(), $objectProperty);
        }

        return $properties;
    }

    public function getPropertiesWithContentTranslationPrefix(AbstractCsvGeneratorConfiguration $configuration): array
    {
        $propertiesWithAttribute = [];
        $properties = $this->getPropertiesForConfig($configuration);

        foreach ($properties as $property) {
            $attribute = $property->getReflectionProperty()->getAttributes(CsvContentTranslationPrefix::class, \ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;
            $attribute = $attribute?->newInstance();

            if (!$attribute instanceof CsvContentTranslationPrefix) {
                continue;
            }

            $propertiesWithAttribute[$property->getName()] = $attribute->translationPrefix;
        }

        return $propertiesWithAttribute;
    }

    private function getPropertiesName(AbstractCsvGeneratorConfiguration $configuration, $object): array
    {
        $context = [ObjectNormalizer::ALL_NULL_VALUES => true];

        if (!empty($configuration->getSerializationGroups())) {
            $context[AbstractNormalizer::GROUPS] = $configuration->getSerializationGroups();
        }

        return \array_keys($this->normalizer->normalize($object, null, $context));
    }
}
