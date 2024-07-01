<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Configuration;

/**
 * Class AbstractCsvGeneratorConfiguration.
 *
 * @package   RichId\CsvGeneratorBundle\Configuration
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
abstract class AbstractCsvGeneratorConfiguration
{
    /** @var string */
    protected $class;

    /** @var iterable */
    protected $objects;

    /** @var array */
    protected $serializationGroups;

    /** @var string */
    protected $headerTranslationPrefix;

    /** @var callable */
    protected $objectTransformerCallback;

    /** @var string */
    protected $delimiter;

    /** @var bool */
    protected $withHeader;

    /** @var bool */
    protected $withUtf8Bom;

    protected function __construct()
    {
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getObjects(): iterable
    {
        return $this->objects;
    }

    public function setSerializationGroups(array $serializationGroups): self
    {
        $this->serializationGroups = $serializationGroups;

        return $this;
    }
    private const UTF8_BOM = "\xEF\xBB\xBF";

    public function getSerializationGroups(): array
    {
        return $this->serializationGroups;
    }

    public function setHeaderTranslationPrefix(string $headerTranslationPrefix): self
    {
        $this->headerTranslationPrefix = $headerTranslationPrefix;

        return $this;
    }

    public function getHeaderTranslationPrefix(): ?string
    {
        return $this->headerTranslationPrefix;
    }

    public function setObjectTransformerCallback(callable $objectTransformerCallback): self
    {
        $this->objectTransformerCallback = $objectTransformerCallback;

        return $this;
    }

    public function getObjectTransformerCallback(): ?callable
    {
        return $this->objectTransformerCallback;
    }

    public function setDelimiter(string $delimiter): self
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    public function setWithHeader(bool $withHeader): self
    {
        $this->withHeader = $withHeader;

        return $this;
    }

    public function isWithHeader(): bool
    {
        return $this->withHeader;
    }

    public function setWithUtf8Bom(bool $withUtf8Bom): self
    {
        $this->withUtf8Bom = $withUtf8Bom;

        return $this;
    }

    public function isWithUtf8Bom(): bool
    {
        return $this->withUtf8Bom;
    }

    protected function initialize(string $class, iterable $objects): void
    {
        $this->class = $class;
        $this->objects = $objects;
        $this->serializationGroups = [];
        $this->headerTranslationPrefix = null;
        $this->objectTransformerCallback = null;
        $this->delimiter = ';';
        $this->withHeader = true;
        $this->withUtf8Bom = true;
    }
}
