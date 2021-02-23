<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Configuration;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Class CsvQueryBuilderGeneratorConfiguration.
 *
 * @package   RichId\CsvGeneratorBundle\Configuration
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class CsvQueryBuilderGeneratorConfiguration extends AbstractCsvGeneratorConfiguration
{
    public static function create(string $class, QueryBuilder $queryBuilder, int $batchSize): CsvQueryBuilderGeneratorConfiguration
    {
        $queryBuilder->setMaxResults($batchSize);

        $config = new static();
        $config->initialize($class, self::iterateWithPaginator($queryBuilder, $batchSize));

        return $config;
    }

    private static function iterateWithPaginator(QueryBuilder $queryBuilder, int $batchSize): \Generator
    {
        $paginator = new Paginator($queryBuilder);
        $iterator = $paginator->getIterator();

        while ($iterator->count() > 0) {
            foreach ($iterator as $object) {
                yield $object;
            }

            $paginator->getQuery()->setFirstResult($paginator->getQuery()->getFirstResult() + $batchSize);
            $iterator = $paginator->getIterator();
        }
    }
}
