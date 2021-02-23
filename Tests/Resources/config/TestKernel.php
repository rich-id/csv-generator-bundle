<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Resources\config;

use RichCongress\WebTestBundle\Kernel\DefaultTestKernel;

/**
 * Class TestKernel
 *
 * @package   RichId\CsvGeneratorBundle\Tests\Resources\config
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 */
class TestKernel extends DefaultTestKernel
{
    public function __construct()
    {
        parent::__construct('test', false);
    }

    public function getProjectDir(): string
    {
        return __DIR__ . '/../../../';
    }

    /**
     * @return string|null
     */
    public function getConfigurationDir(): ?string
    {
        return __DIR__;
    }

}
