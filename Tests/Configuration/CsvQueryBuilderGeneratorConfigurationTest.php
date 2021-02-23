<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Configuration;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Configuration\CsvQueryBuilderGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Tests\Resources\Entity\DummyEntity;

/**
 * Class CsvQueryBuilderGeneratorConfigurationTest.
 *
 * @package   RichId\CsvGeneratorBundle\Tests\Configuration
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration
 * @covers \RichId\CsvGeneratorBundle\Configuration\CsvQueryBuilderGeneratorConfiguration
 *
 * @TestConfig("fixtures")
 */
class CsvQueryBuilderGeneratorConfigurationTest extends TestCase
{
    /** @var EntityManagerInterface */
    public $entityManager;

    public function testInstanciateConfiguration(): void
    {
        $configuration = CsvQueryBuilderGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2);

        $this->assertInstanceOf(CsvQueryBuilderGeneratorConfiguration::class, $configuration);
        $this->assertInstanceOf(AbstractCsvGeneratorConfiguration::class, $configuration);
    }

    public function testConfiguration(): void
    {
        $qb = $this->buildQueryBuilder();

        $configuration = CsvQueryBuilderGeneratorConfiguration::create(DummyEntity::class, $qb, 2);

        $this->assertSame(2, $qb->getMaxResults());

        $this->assertSame(DummyEntity::class, $configuration->getClass());
        $this->assertSame([], $configuration->getSerializationGroups());
        $this->assertNull($configuration->getHeaderTranslationPrefix());
        $this->assertNull($configuration->getObjectTransformerCallback());
        $this->assertSame(';', $configuration->getDelimiter());
        $this->assertTrue($configuration->isWithHeader());
        $this->assertInstanceOf(\Generator::class, $configuration->getObjects());
    }

    private function buildQueryBuilder(): QueryBuilder
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb->select('de')
            ->from(DummyEntity::class, 'de');
    }
}
