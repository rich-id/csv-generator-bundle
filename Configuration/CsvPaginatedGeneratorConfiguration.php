<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Configuration;

use Doctrine\ORM\QueryBuilder;

/**
 * Class CsvPaginatedGeneratorConfiguration.
 *
 * @package   RichId\CsvGeneratorBundle\Configuration
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class CsvPaginatedGeneratorConfiguration extends AbstractCsvGeneratorConfiguration
{
    /** @var QueryBuilder */
    protected $queryBuilder;

    /** @var int */
    protected $batchSize;

    public function getQueryBuilder(): QueryBuilder
    {
        return $this->queryBuilder;
    }

    public function getBatchSize(): int
    {
        return $this->batchSize;
    }

    public static function create(string $class, QueryBuilder $queryBuilder, int $batchSize): CsvPaginatedGeneratorConfiguration
    {
        $config = new static();
        $config->initialize($class);

        $config->queryBuilder = $queryBuilder;
        $config->batchSize = $batchSize;

        $config->queryBuilder->setMaxResults($batchSize);

        return $config;
    }
}
