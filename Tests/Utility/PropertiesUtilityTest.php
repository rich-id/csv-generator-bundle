<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Utility;

use RichCongress\TestFramework\TestConfiguration\Attribute\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Configuration\CsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Data\Property;
use RichId\CsvGeneratorBundle\Tests\Resources\Entity\DummyEntity;
use RichId\CsvGeneratorBundle\Utility\PropertiesUtility;

/**
 * Class PropertiesUtilityTest.
 *
 * @package   RichId\CsvGeneratorBundle\Tests\Helper
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\CsvGeneratorBundle\Utility\PropertiesUtility
 */
#[TestConfig('kernel')]
class PropertiesUtilityTest extends TestCase
{
    /** @var PropertiesUtility */
    public $helper;

    public function testGetPropertiesNamesForConfig(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [])
            ->setSerializationGroups(['my_serialization_group']);

        $result = $this->helper->getPropertiesNamesForConfig($configuration);

        $this->assertSame(['id', 'name', 'other'], $result);
    }

    public function testGetPropertiesForConfig(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [])
            ->setSerializationGroups(['my_serialization_group']);

        $result = $this->helper->getPropertiesForConfig($configuration);

        $this->assertCount(3, $result);

        $this->assertInstanceOf(Property::class, $result[0]);
        $this->assertSame('id', $result[0]->getName());

        $this->assertInstanceOf(Property::class, $result[1]);
        $this->assertSame('name', $result[1]->getName());

        $this->assertInstanceOf(Property::class, $result[2]);
        $this->assertSame('other', $result[2]->getName());
    }

    public function testGetPropertiesWithContentTranslationPrefix(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [])
            ->setSerializationGroups(['my_serialization_group']);

        $result = $this->helper->getPropertiesWithContentTranslationPrefix($configuration);

        $this->assertCount(1, $result);
        $this->assertArrayHasKey('other', $result);
        $this->assertSame('my_content_translation_prefix.', $result['other']);
    }
}
