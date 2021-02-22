<?php declare(strict_types=1);

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    RichCongress\BundleToolbox\RichCongressBundleToolboxBundle::class => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['test' => true],
    DAMA\DoctrineTestBundle\DAMADoctrineTestBundle::class => ['test' => true],
    RichCongress\WebTestBundle\RichCongressWebTestBundle::class => ['test' => true],
    RichId\CsvGeneratorBundle\RichIdCsvGeneratorBundle::class => ['test' => true],
];
