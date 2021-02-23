<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Configuration;

use RichCongress\TestTools\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Configuration\CsvGeneratorConfiguration;

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
        $configuration = CsvGeneratorConfiguration::create('class_name', []);

        $this->assertSame('class_name', $configuration->getClass());
        $this->assertSame([], $configuration->getSerializationGroups());
        $this->assertNull($configuration->getHeaderTranslationPrefix());
        $this->assertNull($configuration->getObjectTransformerCallback());
        $this->assertSame(';', $configuration->getDelimiter());
        $this->assertTrue($configuration->isWithHeader());
        $this->assertSame([], $configuration->getObjects());
    }
}
