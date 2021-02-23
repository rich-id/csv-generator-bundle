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
                'other'      => 'Other 1',
                'title'      => 'Title 1',
                'otherTitle' => 'OtherTitle 1',
            ]
        );

        $this->createObject(
            DummyEntity::class,
            '2',
            [
                'name'       => 'Entity 2',
                'other'      => 'Other 2',
                'title'      => 'Title 2',
                'otherTitle' => 'OtherTitle 2',
            ]
        );

        $this->createObject(
            DummyEntity::class,
            '3',
            [
                'name'       => 'Entity 3',
                'other'      => 'Other 3',
                'title'      => 'Title 3',
                'otherTitle' => 'OtherTitle 3',
            ]
        );

        $this->createObject(
            DummyEntity::class,
            '4',
            [
                'name'       => 'Entity 4',
                'other'      => 'Other 4',
                'title'      => 'Title 4',
                'otherTitle' => 'OtherTitle 4',
            ]
        );

        $this->createObject(
            DummyEntity::class,
            '5',
            [
                'name'       => 'Entity 5',
                'other'      => 'Other 5',
                'title'      => 'Title 5',
                'otherTitle' => 'OtherTitle 5',
            ]
        );
    }
}
