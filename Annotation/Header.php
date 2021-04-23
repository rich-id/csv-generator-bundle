<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Annotation;

/**
 * Class Header
 *
 * @package    RichId\CsvGeneratorBundle\Annotation
 * @author     Nicolas Guilloux <nicolas.guilloux@rich-id.fr>
 * @copyright  2014 - 2021 RichID (https://www.rich-id.fr)
 *
 * @Annotation
 * @Target({"CLASS"})
 */
class Header extends Translate
{
    /** @var string[] */
    public $keys = [];
}
