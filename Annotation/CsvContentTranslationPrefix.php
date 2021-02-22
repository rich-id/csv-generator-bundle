<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Annotation;

/**
 * Class CsvContentTranslationPrefix.
 *
 * @package   RichId\CsvGeneratorBundle\Annotation
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @Annotation
 * @Target({"PROPERTY"})
 */
class CsvContentTranslationPrefix
{
    /** @var string */
    public $translationPrefix;
}

