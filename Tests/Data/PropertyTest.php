<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Data;

use RichCongress\TestTools\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Data\Property;
use RichId\CsvGeneratorBundle\Tests\Resources\Entity\DummyEntity;

/**
 * Class PropertyTest.
 *
 * @package   RichId\CsvGeneratorBundle\Tests\Data
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\CsvGeneratorBundle\Data\Property
 */
class PropertyTest extends TestCase
{
    public function testModel(): void
    {
        $reflectionProperty = new \ReflectionProperty(DummyEntity::class, 'id');

        $model = Property::build('id', $reflectionProperty);

        $this->assertSame('id', $model->getName());
        $this->assertSame($reflectionProperty, $model->getReflectionProperty());
    }
}
