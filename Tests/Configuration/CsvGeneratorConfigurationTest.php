<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Configuration;

use RichCongress\TestTools\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Configuration\CsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Tests\Resources\Entity\DummyEntity;

/**
 * Class CsvGeneratorConfigurationTest.
 *
 * @package   RichId\CsvGeneratorBundle\Tests\Configuration
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration
 * @covers \RichId\CsvGeneratorBundle\Configuration\CsvGeneratorConfiguration
 */
class CsvGeneratorConfigurationTest extends TestCase
{
    public function testInstanciateConfiguration(): void
    {
        $configuration = CsvGeneratorConfiguration::create('class_name', []);

        $this->assertInstanceOf(CsvGeneratorConfiguration::class, $configuration);
        $this->assertInstanceOf(AbstractCsvGeneratorConfiguration::class, $configuration);
    }

    public function testConfiguration(): void
    {
        $entity1 = DummyEntity::build(1, 'name', 'value1');
        $entity2 = DummyEntity::build(2, 'name', 'value1');

        $configuration = CsvGeneratorConfiguration::create('class_name', [$entity1, $entity2]);

        $this->assertCount(2, $configuration->getObjects());
        $this->assertSame($entity1, $configuration->getObjects()[0]);
        $this->assertSame($entity2, $configuration->getObjects()[1]);

        $this->assertSame('class_name', $configuration->getClass());
        $this->assertSame([], $configuration->getSerializationGroups());
        $this->assertNull($configuration->getHeaderTranslationPrefix());
        $this->assertNull($configuration->getObjectTransformerCallback());
        $this->assertSame(';', $configuration->getDelimiter());
        $this->assertTrue($configuration->isWithHeader());
    }
}
