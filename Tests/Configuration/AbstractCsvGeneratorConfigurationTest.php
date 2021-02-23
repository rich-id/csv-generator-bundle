<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Configuration;

use RichCongress\TestTools\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Configuration\CsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Tests\Resources\Entity\DummyEntity;

/**
 * Class AbstractCsvGeneratorConfigurationTest.
 *
 * @package   RichId\CsvGeneratorBundle\Tests\Configuration
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration
 */
class AbstractCsvGeneratorConfigurationTest extends TestCase
{
    public function testConfiguration(): void
    {
        $callback = function () {
            return '';
        };

        $entity1 = DummyEntity::build(1, 'name', 'value1');
        $entity2 = DummyEntity::build(2, 'name', 'value1');

        $configuration = CsvGeneratorConfiguration::create('class_name', [$entity1, $entity2])
            ->setDelimiter('delimiter')
            ->setSerializationGroups(['group_1', 'group_2'])
            ->setHeaderTranslationPrefix('header_translation_prefix_')
            ->setWithHeader(false)
            ->setObjectTransformerCallback($callback);

        $this->assertSame('class_name', $configuration->getClass());
        $this->assertSame(['group_1', 'group_2'], $configuration->getSerializationGroups());
        $this->assertSame('header_translation_prefix_', $configuration->getHeaderTranslationPrefix());
        $this->assertSame($callback, $configuration->getObjectTransformerCallback());
        $this->assertSame('delimiter', $configuration->getDelimiter());
        $this->assertFalse($configuration->isWithHeader());
        $this->assertSame([$entity1, $entity2], $configuration->getObjects());
    }
}
