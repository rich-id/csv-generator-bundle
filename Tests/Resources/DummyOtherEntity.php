<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Resources;

final class DummyOtherEntity
{
    /** @var int  */
    private $id;

    /** @var string  */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public static function buildFromDummyEntity(DummyEntity $dummyEntity): DummyOtherEntity
    {
        $entity = new self();

        $entity->id = $dummyEntity->getId();
        $entity->name = $dummyEntity->getName();

        return $entity;
    }
}
