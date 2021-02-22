<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Configuration;

use Doctrine\ORM\QueryBuilder;
use RichCongress\TestTools\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Configuration\CsvPaginatedGeneratorConfiguration;

/**
 * Class CsvGeneratorConfigurationTest.
 *
 * @package   RichId\CsvGeneratorBundle\Tests\Configuration
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration
 * @covers \RichId\CsvGeneratorBundle\Configuration\CsvPaginatedGeneratorConfiguration
 */
class CsvPaginatedGeneratorConfigurationTest extends TestCase
{
    public function testInstanciateConfiguration(): void
    {
        $qb = \Mockery::mock(QueryBuilder::class)->makePartial();

        $configuration = CsvPaginatedGeneratorConfiguration::create('class_name', $qb, 20);

        $this->assertInstanceOf(CsvPaginatedGeneratorConfiguration::class, $configuration);
        $this->assertInstanceOf(AbstractCsvGeneratorConfiguration::class, $configuration);
    }

    public function testConfiguration(): void
    {
        $qb = \Mockery::mock(QueryBuilder::class)->makePartial();

        $configuration = CsvPaginatedGeneratorConfiguration::create('class_name', $qb, 20);

        $this->assertSame($qb, $configuration->getQueryBuilder());
        $this->assertSame(20, $configuration->getBatchSize());
        $this->assertSame(20, $qb->getMaxResults());

        $this->assertSame('class_name', $configuration->getClass());
        $this->assertSame([], $configuration->getSerializationGroups());
        $this->assertNull($configuration->getHeaderTranslationPrefix());
        $this->assertNull($configuration->getObjectTransformerCallback());
        $this->assertSame(';', $configuration->getDelimiter());
        $this->assertTrue($configuration->isWithHeader());
    }
}
