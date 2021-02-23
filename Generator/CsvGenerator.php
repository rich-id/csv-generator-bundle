<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Generator;

use Doctrine\ORM\Tools\Pagination\Paginator;
use RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Configuration\CsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Configuration\CsvPaginatedGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Utility\PropertiesUtility;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class CsvGenerator
 *
 * @package   RichId\CsvGeneratorBundle\Generator
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class CsvGenerator implements CsvGeneratorInterface
{
    /** @var SerializerInterface */
    protected $serializer;

    /** @var NormalizerInterface */
    protected $normalizer;

    /** @var TranslatorInterface */
    protected $translator;

    /** @var PropertiesUtility */
    protected $propertiesUtility;

    public function __construct(SerializerInterface $serializer, NormalizerInterface $normalizer, TranslatorInterface $translator, PropertiesUtility $propertiesUtility)
    {
        $this->serializer = $serializer;
        $this->normalizer = $normalizer;
        $this->translator = $translator;
        $this->propertiesUtility = $propertiesUtility;
    }

    public function getContent(AbstractCsvGeneratorConfiguration $configuration): string
    {
        $content = '';

        if ($configuration->isWithHeader()) {
            $content .= $this->getHeaderContent($configuration);
        }

        $this->generateContent(
            $configuration,
            function ($object, AbstractCsvGeneratorConfiguration $configuration, array $contentTranslationPrefixes) use (&$content) {
                $content .= $this->getRowContent($object, $configuration, $contentTranslationPrefixes);
            }
        );

        return $content;
    }

    public function streamResponse(AbstractCsvGeneratorConfiguration $configuration, string $filename): StreamedResponse
    {
        return new StreamedResponse(
            function () use ($configuration) {
                if ($configuration->isWithHeader()) {
                    $chunk = $this->getHeaderContent($configuration);
                    $this->sendStreamChunk($chunk);
                }

                $this->generateContent(
                    $configuration,
                    function ($object, AbstractCsvGeneratorConfiguration $configuration, array $contentTranslationPrefixes) {
                        $chunk = $this->getRowContent($object, $configuration, $contentTranslationPrefixes);
                        $this->sendStreamChunk($chunk);
                    }
                );
            }, Response::HTTP_OK, [
                 'Content-Type'        => 'text/csv',
                 'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"'
             ]
        );
    }

    /**
     * This interferes with the way PHPUnit handles the outputs
     *
     * @codeCoverageIgnore
     */
    protected function sendStreamChunk(string $chunk): void
    {
        echo $chunk;

        ob_flush();
        flush();
    }

    protected function getHeaderContent(AbstractCsvGeneratorConfiguration $configuration): string
    {
        $properties = $this->propertiesUtility->getPropertiesNamesForConfig($configuration);

        if ($configuration->getHeaderTranslationPrefix() !== null) {
            $properties = \array_map(
                function (string $propertyName) use ($configuration) {
                    return $this->translator->trans(\sprintf('%s%s', $configuration->getHeaderTranslationPrefix(), $propertyName));
                },
                $properties
            );
        }

        return $this->serializer->serialize(
            $properties,
            CsvEncoder::FORMAT,
            [CsvEncoder::DELIMITER_KEY => $configuration->getDelimiter(), CsvEncoder::NO_HEADERS_KEY => true]
        );
    }

    protected function getRowContent($object, AbstractCsvGeneratorConfiguration $configuration, array $contentTranslationPrefixes): string
    {
        if ($configuration->getObjectTransformerCallback() !== null) {
            $object = ($configuration->getObjectTransformerCallback())($object);
        }

        $context = empty($configuration->getSerializationGroups()) ? [] : [AbstractNormalizer::GROUPS => $configuration->getSerializationGroups()];
        $encodedObject = $this->normalizer->normalize($object, null, $context);

        foreach ($contentTranslationPrefixes as $propertyName => $contentTranslationPrefix) {
            if (!isset($encodedObject[$propertyName]) || $encodedObject[$propertyName] === null || $encodedObject[$propertyName] === '') {
                continue;
            }

            $encodedObject[$propertyName] = $this->translator->trans(\sprintf('%s%s', $contentTranslationPrefix, $encodedObject[$propertyName]));
        }

        return $this->serializer->serialize(
            $encodedObject,
            CsvEncoder::FORMAT,
            [CsvEncoder::DELIMITER_KEY => $configuration->getDelimiter(), CsvEncoder::NO_HEADERS_KEY => true]
        );
    }

    private function generateContent(AbstractCsvGeneratorConfiguration $configuration, callable $action): void
    {
        $contentTranslationPrefixes = $this->propertiesUtility->getPropertiesWithContentTranslationPrefix($configuration);

        if ($configuration instanceof CsvPaginatedGeneratorConfiguration) {
            $this->iterateWithPaginator(
                $configuration,
                static function ($object) use ($action, $configuration, $contentTranslationPrefixes) {
                    $action($object, $configuration, $contentTranslationPrefixes);
                }
            );
        }

        if ($configuration instanceof CsvGeneratorConfiguration) {
            foreach ($configuration->getObjects() as $object) {
                $action($object, $configuration, $contentTranslationPrefixes);
            }
        }
    }

    private function iterateWithPaginator(CsvPaginatedGeneratorConfiguration $configuration, callable $action): void
    {
        $paginator = new Paginator($configuration->getQueryBuilder());
        $iterator = $paginator->getIterator();

        while ($iterator->count() > 0) {
            foreach ($iterator as $object) {
                $action($object);
            }

            $paginator->getQuery()->setFirstResult($paginator->getQuery()->getFirstResult() + $configuration->getBatchSize());
            $iterator = $paginator->getIterator();
        }
    }
}
