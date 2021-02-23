<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Resources\Fixtures;

use RichCongress\RecurrentFixturesTestBundle\DataFixture\AbstractFixture;
use RichId\CsvGeneratorBundle\Tests\Resources\Entity\DummyEntity;

final class DummyEntityFixtures extends AbstractFixture
{
    protected function loadFixtures(): void
    {
        $this->createObject(
            DummyEntity::class,
            '1',
            [
                'name'       => 'Entity 1',
                'other'      => 'value2',
                'title'      => 'Title 1',
                'otherTitle' => null,
            ]
        );

        $this->createObject(
            DummyEntity::class,
            '2',
            [
                'name'       => 'Entity 2',
                'other'      => 'value1',
                'title'      => 'Title 2',
                'otherTitle' => 'value2',
            ]
        );

        $this->createObject(
            DummyEntity::class,
            '3',
            [
                'name'       => 'Entity 3',
                'other'      => 'value2',
                'title'      => 'Title 3',
                'otherTitle' => 'value1',
            ]
        );

        $this->createObject(
            DummyEntity::class,
            '4',
            [
                'name'       => 'Entity 4',
                'other'      => 'value1',
                'title'      => 'Title 4',
                'otherTitle' => 'value2',
            ]
        );

        $this->createObject(
            DummyEntity::class,
            '5',
            [
                'name'       => 'Entity 5',
                'other'      => 'value2',
                'title'      => 'Title 5',
                'otherTitle' => 'value1',
            ]
        );
    }
}
