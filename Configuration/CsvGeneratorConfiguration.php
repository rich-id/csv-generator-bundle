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
    public static function create(string $class, iterable $objects): CsvGeneratorConfiguration
    {
        $config = new static();
        $config->initialize($class, $objects);

        return $config;
    }
}
