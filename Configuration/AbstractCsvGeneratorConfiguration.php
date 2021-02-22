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

    protected function __construct()
    {
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function setSerializationGroups(array $serializationGroups): self
    {
        $this->serializationGroups = $serializationGroups;

        return $this;
    }

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

    protected function initialize(string $class): void
    {
        $this->class = $class;
        $this->serializationGroups = [];
        $this->headerTranslationPrefix = null;
        $this->objectTransformerCallback = null;
        $this->delimiter = ';';
        $this->withHeader = true;
    }
}
