<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\Integration\CatalogRepository;

use Albomon\Catalog\Adapter\Persistence\CatalogRepository;
use Albomon\Catalog\Application\Model\CatalogItem;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class CatalogRepositoryTest extends TestCase
{
    private const DEFAULT_FIXTURES_DIR = __DIR__ . '/Fixtures';

    private const DEFAULT_FIXTURES_FILENAME = '/test-catalog.json';

    private const FIRST_UUID = '7981d562-35ca-47a2-a855-a80339760acb';

    private const SECOND_UUID = '1ecd8953-9785-4f37-988a-8e83e9a12ddb';

    private const FIRST_RSS_FEED_URL = 'https://first.irrelevant.feed';

    private const SECOND_RSS_FEED_URL = 'https://second.irrelevant.feed';

    protected function setUp(): void
    {
        $defaultFile = self::DEFAULT_FIXTURES_DIR . self::DEFAULT_FIXTURES_FILENAME;
        if (file_exists($defaultFile)) {
            unlink($defaultFile);
        }
    }

    public function testThrowExceptionIfEmptyCatalogDirectoryParam(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Expected a catalog directory parameter');

        new CatalogRepository('', '/test-preloaded-catalog.json');
    }

    public function testThrowExceptionIfCatalogFilenameParamIsNotJson(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Expected a filename with "json" extension');

        new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/irrelevant.txt');
    }

    public function testShouldReturnCatalogItems(): void
    {
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/test-preloaded-catalog.json');

        self::assertNotEquals([], $sut->getItems());
    }

    public function testShouldAddCatalogItem(): void
    {
        $item = CatalogItem::with(self::FIRST_UUID, self::FIRST_RSS_FEED_URL);
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, self::DEFAULT_FIXTURES_FILENAME);

        $sut->save($item);

        self::assertEquals(1, \count($sut->getItems()));
        self::assertFileExists(self::DEFAULT_FIXTURES_DIR . self::DEFAULT_FIXTURES_FILENAME);
    }

    public function testShouldAddMultipleCatalogItem(): void
    {
        $itemFirst = CatalogItem::with(self::FIRST_UUID, self::FIRST_RSS_FEED_URL);
        $itemSecond = CatalogItem::with(self::SECOND_UUID, self::SECOND_RSS_FEED_URL);
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, self::DEFAULT_FIXTURES_FILENAME);

        $sut->save($itemFirst, $itemSecond);

        self::assertEquals(2, \count($sut->getItems()));
        self::assertFileExists(self::DEFAULT_FIXTURES_DIR . self::DEFAULT_FIXTURES_FILENAME);
    }

    public function testShouldLoadAnEmptyCatalogFromFilesystem(): void
    {
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/test-empty-catalog.json');

        self::assertEquals([], $sut->getItems());
    }

    public function testShouldLoadAPreloadedCatalogFromFilesystem(): void
    {
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/test-preloaded-catalog.json');

        self::assertNotEquals([], $sut->getItems());
        self::assertEquals(2, \count($sut->getItems()));
    }
}
