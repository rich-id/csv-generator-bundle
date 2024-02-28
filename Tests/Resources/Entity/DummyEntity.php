<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Resources\Entity;

use Doctrine\ORM\Mapping as ORM;
use RichId\CsvGeneratorBundle\Attribute\CsvContentTranslationPrefix;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Table('dummy_entity')]
#[ORM\Entity]
class DummyEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[Groups('my_serialization_group')]
    private int $id;

    #[ORM\Column(name: 'name', type: 'string', length: 250, nullable: false)]
    #[Groups("my_serialization_group")]
    private string $name;

    #[ORM\Column(name: 'other', type: 'string', length: 250, nullable: false)]
    #[Groups('my_serialization_group')]
    #[CsvContentTranslationPrefix('my_content_translation_prefix.')]
    private string $other;

    #[ORM\Column(name: 'title', type: 'string', length: 250, nullable: false)]
    private string $title;

    #[ORM\Column(name: 'other_title', type: 'string', length: 250, nullable: true)]
    #[CsvContentTranslationPrefix("my_content_translation_prefix.")]
    public ?string $otherTitle;

    public static function build(int $id, string $name, string $other): DummyEntity
    {
        $entity = new self();

        $entity->id = $id;
        $entity->name = $name;
        $entity->other = $other;

        return $entity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getOther(): ?string
    {
        return $this->other;
    }
}
