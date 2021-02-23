<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Generator;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Configuration\CsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Configuration\CsvPaginatedGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Generator\CsvGeneratorInterface;
use RichId\CsvGeneratorBundle\Tests\Resources\Entity\DummyEntity;
use RichId\CsvGeneratorBundle\Tests\Resources\Entity\DummyOtherEntity;
use RichId\CsvGeneratorBundle\Tests\Resources\Stub\CsvGeneratorStub;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Class CsvGeneratorTest.
 *
 * @package   RichId\CsvGeneratorBundle\Tests\Generator
 * @author    Hugo Dumazeau <hugo.dumazeau@rich-id.fr>
 * @copyright 2014 - 2021 RichId (https://www.rich-id.fr)
 *
 * @covers \RichId\CsvGeneratorBundle\Generator\CsvGenerator
 *
 * @TestConfig("fixtures")
 */
class CsvGeneratorTest extends TestCase
{
    protected const RESOURCES_DIR = __DIR__ . '/../Resources/files/';

    /** @var CsvGeneratorStub */
    public $generator;

    /** @var EntityManagerInterface */
    public $entityManager;

    public function testInstanciate(): void
    {
        $this->assertInstanceOf(CsvGeneratorInterface::class, $this->generator);
    }

    public function testGetContent(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities());

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities.csv'), $content);
    }

    public function testGetContentWithPaginatedConfiguration(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities.csv'), $content);
    }

    public function testGetContentWithoutHeader(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities())
            ->setWithHeader(false);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-without-header.csv'), $content);
    }

    public function testGetContentWithPaginatedConfigurationWithoutHeader(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2)
            ->setWithHeader(false);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-without-header.csv'), $content);
    }

    public function testGetContentWithSerializationGroups(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities())
            ->setSerializationGroups(['my_serialization_group']);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-serialization-groups.csv'), $content);
    }

    public function testGetContentWithPaginatedConfigurationWithSerializationGroups(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2)
            ->setSerializationGroups(['my_serialization_group']);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-serialization-groups.csv'), $content);
    }

    public function testGetContentWithCustomDelimiter(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities())
            ->setDelimiter("&");

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-delimiter.csv'), $content);
    }

    public function testGetContentWithPaginatedConfigurationWithCustomDelimiter(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2)
            ->setDelimiter("&");

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-delimiter.csv'), $content);
    }

    public function testGetContentWithHeaderTranslationPefix(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities())
            ->setHeaderTranslationPrefix("header_prefix.");

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-header-prefix.csv'), $content);
    }

    public function testGetContentWithPaginatedConfigurationWithHeaderTranslationPefix(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2)
            ->setHeaderTranslationPrefix("header_prefix.");

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-header-prefix.csv'), $content);
    }

    public function testGetContentWithCallback(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyOtherEntity::class, $this->getEntities())
            ->setObjectTransformerCallback([DummyOtherEntity::class, 'buildFromDummyEntity']);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-callback.csv'), $content);
    }

    public function testGetContentWithPaginatedConfigurationWithCallback(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyOtherEntity::class, $this->buildQueryBuilder(), 2)
            ->setObjectTransformerCallback([DummyOtherEntity::class, 'buildFromDummyEntity']);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-callback.csv'), $content);
    }

    public function testStreamResponse(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities());

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithPaginatedConfiguration(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithoutHeader(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities())
            ->setWithHeader(false);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-without-header.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithPaginatedConfigurationWithoutHeader(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2)
            ->setWithHeader(false);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-without-header.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithSerializationGroups(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities())
            ->setSerializationGroups(['my_serialization_group']);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-serialization-groups.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithPaginatedConfigurationWithSerializationGroups(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2)
            ->setSerializationGroups(['my_serialization_group']);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-serialization-groups.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithCustomDelimiter(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities())
            ->setDelimiter("&");

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-delimiter.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithPaginatedConfigurationWithCustomDelimiter(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2)
            ->setDelimiter("&");

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-delimiter.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithHeaderTranslationPefix(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, $this->getEntities())
            ->setHeaderTranslationPrefix("header_prefix.");

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-header-prefix.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithPaginatedConfigurationWithHeaderTranslationPefix(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyEntity::class, $this->buildQueryBuilder(), 2)
            ->setHeaderTranslationPrefix("header_prefix.");

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-header-prefix.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithCallback(): void
    {
        $configuration = CsvGeneratorConfiguration::create(DummyOtherEntity::class, $this->getEntities())
            ->setObjectTransformerCallback([DummyOtherEntity::class, 'buildFromDummyEntity']);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-callback.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithPaginatedConfigurationWithCallback(): void
    {
        $configuration = CsvPaginatedGeneratorConfiguration::create(DummyOtherEntity::class, $this->buildQueryBuilder(), 2)
            ->setObjectTransformerCallback([DummyOtherEntity::class, 'buildFromDummyEntity']);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-callback.csv'), $this->generator->getStreamedContent());
    }

    private function getEntities(): array
    {
        return [
            $this->getReference(DummyEntity::class, '1'),
            $this->getReference(DummyEntity::class, '2'),
            $this->getReference(DummyEntity::class, '3'),
            $this->getReference(DummyEntity::class, '4'),
            $this->getReference(DummyEntity::class, '5'),
        ];
    }

    private function buildQueryBuilder(): QueryBuilder
    {
        $qb = $this->entityManager->createQueryBuilder();

        return $qb->select('de')
            ->from(DummyEntity::class, 'de');
    }
}
