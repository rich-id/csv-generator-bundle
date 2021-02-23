<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Resources\Entity;

use Doctrine\ORM\Mapping as ORM;
use RichId\CsvGeneratorBundle\Annotation\CsvContentTranslationPrefix;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Table("dummy_entity")
 * @ORM\Entity
 */
class DummyEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups("my_serialization_group")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=false, name="name")
     *
     * @Groups("my_serialization_group")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=false, name="other")
     *
     * @Groups("my_serialization_group")
     * @CsvContentTranslationPrefix("my_content_translation_prefix.")
     */
    private $other;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=false, name="title")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, nullable=false, name="other_title")
     *
     * @CsvContentTranslationPrefix("my_content_translation_prefix.")
     */
    public $otherTitle;

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
