<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Generator;

use RichId\CsvGeneratorBundle\Configuration\AbstractCsvGeneratorConfiguration;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Interface CsvGeneratorInterface.
 *
 * @package   RichId\CsvGeneratorBundle\Generator
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
interface CsvGeneratorInterface
{
    public function getContent(AbstractCsvGeneratorConfiguration $configuration): string;
    public function streamResponse(AbstractCsvGeneratorConfiguration $configuration, string $filename): StreamedResponse;
}
