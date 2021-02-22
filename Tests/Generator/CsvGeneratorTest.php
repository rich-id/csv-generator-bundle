<?php declare(strict_types=1);

namespace RichId\CsvGeneratorBundle\Tests\Generator;

use RichCongress\TestFramework\TestConfiguration\Annotation\TestConfig;
use RichCongress\TestSuite\TestCase\TestCase;
use RichId\CsvGeneratorBundle\Configuration\CsvGeneratorConfiguration;
use RichId\CsvGeneratorBundle\Generator\CsvGeneratorInterface;
use RichId\CsvGeneratorBundle\Tests\Resources\DummyEntity;
use RichId\CsvGeneratorBundle\Tests\Resources\DummyOtherEntity;
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
 * @TestConfig("kernel")
 */
class CsvGeneratorTest extends TestCase
{
    protected const RESOURCES_DIR = __DIR__ . '/../Resources/files/';

    /** @var CsvGeneratorStub */
    public $generator;

    public function testInstanciate(): void
    {
        $this->assertInstanceOf(CsvGeneratorInterface::class, $this->generator);
    }

    public function testGetContent(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2]);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities.csv'), $content);
    }

    public function testGetContentWithoutHeader(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2])
            ->setWithHeader(false);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-without-header.csv'), $content);
    }

    public function testGetContentWithSerializationGroups(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2])
            ->setSerializationGroups(['my_serialization_group']);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-serialization-groups.csv'), $content);
    }

    public function testGetContentWithCustomDelimiter(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2])
            ->setDelimiter("&");

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-delimiter.csv'), $content);
    }

    public function testGetContentWithHeaderTranslationPefix(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2])
            ->setHeaderTranslationPrefix("header_prefix.");

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-header-prefix.csv'), $content);
    }

    public function testGetContentWithCallback(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyOtherEntity::class, [$entity1, $entity2])
            ->setObjectTransformerCallback([DummyOtherEntity::class, 'buildFromDummyEntity']);

        $content = $this->generator->getContent($configuration);

        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-callback.csv'), $content);
    }

    public function testStreamResponse(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2]);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithoutHeader(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2])
            ->setWithHeader(false);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-without-header.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithSerializationGroups(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2])
            ->setSerializationGroups(['my_serialization_group']);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-serialization-groups.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithCustomDelimiter(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2])
            ->setDelimiter("&");

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-delimiter.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithHeaderTranslationPefix(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyEntity::class, [$entity1, $entity2])
            ->setHeaderTranslationPrefix("header_prefix.");

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-header-prefix.csv'), $this->generator->getStreamedContent());
    }

    public function testStreamResponseWithCallback(): void
    {
        $entity1 = new DummyEntity(1, 'name', 'value1');
        $entity2 = new DummyEntity(2, 'name', 'value2');

        $configuration = CsvGeneratorConfiguration::create(DummyOtherEntity::class, [$entity1, $entity2])
            ->setObjectTransformerCallback([DummyOtherEntity::class, 'buildFromDummyEntity']);

        $response = $this->generator->streamResponse($configuration, 'my_file');
        $response->sendContent();

        $this->assertInstanceOf(StreamedResponse::class, $response);
        $this->assertEquals(\file_get_contents(self::RESOURCES_DIR . '/dummy-entities-with-callback.csv'), $this->generator->getStreamedContent());
    }
}
