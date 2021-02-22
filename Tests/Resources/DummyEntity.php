<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Resources;

use RichId\CsvGeneratorBundle\Annotation\CsvContentTranslationPrefix;
use Symfony\Component\Serializer\Annotation\Groups;

final class DummyEntity
{
    /**
     * @var int
     * 
     * @Groups("my_serialization_group")
     */
    private $id;

    /**
     * @var string
     *
     * @Groups("my_serialization_group")
     */
    private $name;

    /**
     * @var string
     * 
     * @Groups("my_serialization_group")
     * @CsvContentTranslationPrefix("my_content_translation_prefix.")
     */
    private $other;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     * @CsvContentTranslationPrefix("my_content_translation_prefix.")
     */
    public $otherTitle;

    public function __construct(int $id, string $name, string $other)
    {
        $this->id = $id;
        $this->name = $name;
        $this->other = $other;
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
