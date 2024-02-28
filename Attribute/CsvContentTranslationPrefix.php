<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Attribute;

/**
 * Class CsvContentTranslationPrefix.
 *
 * @package   RichId\CsvGeneratorBundle\Attribute
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class CsvContentTranslationPrefix
{
    public function __construct(
        public string $translationPrefix
    ) {}
}

