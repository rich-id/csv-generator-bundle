<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Configuration;

/**
 * Class CsvGeneratorConfiguration.
 *
 * @package   RichId\CsvGeneratorBundle\Configuration
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class CsvGeneratorConfiguration extends AbstractCsvGeneratorConfiguration
{
    /** @var array */
    protected $objects;

    public function getObjects(): array
    {
        return $this->objects;
    }

    public static function create(string $class, array $objects): CsvGeneratorConfiguration
    {
        $config = new static();
        $config->initialize($class);

        $config->objects = $objects;

        return $config;
    }
}