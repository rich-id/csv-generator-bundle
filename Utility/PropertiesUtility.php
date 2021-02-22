<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Utility;

use Doctrine\Common\Annotations\AnnotationReader;
use RichId\CsvGeneratorBundle\Annotation\CsvContentTranslationPrefix;
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
    /** @var NormalizerInterface */
    protected $normalizer;

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
        $propertiesWithAnnotation = [];
        $annotationReader = new AnnotationReader();
        $properties = $this->getPropertiesForConfig($configuration);

        foreach ($properties as $property) {
            $annotation = $annotationReader->getPropertyAnnotation($property->getReflectionProperty(), CsvContentTranslationPrefix::class);

            if (!$annotation instanceof CsvContentTranslationPrefix) {
                continue;
            }

            $propertiesWithAnnotation[$property->getName()] = $annotation->translationPrefix;
        }

        return $propertiesWithAnnotation;
    }

    private function getPropertiesName(AbstractCsvGeneratorConfiguration $configuration, $object): array
    {
        $context = empty($configuration->getSerializationGroups()) ? [] : [AbstractNormalizer::GROUPS => $configuration->getSerializationGroups()];

        return array_keys($this->normalizer->normalize($object, null, $context));
    }
}
