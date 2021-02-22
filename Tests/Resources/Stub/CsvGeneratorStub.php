<?php

namespace RichId\CsvGeneratorBundle\Tests\Resources\Stub;

use RichId\CsvGeneratorBundle\Generator\CsvGenerator;

class CsvGeneratorStub extends CsvGenerator
{
    /** @var string */
    protected $streamedContent = '';

    protected function sendStreamChunk(string $chunk): void
    {
        $this->streamedContent .= $chunk;
    }

    public function getStreamedContent(): string
    {
        return $this->streamedContent;
    }
}
