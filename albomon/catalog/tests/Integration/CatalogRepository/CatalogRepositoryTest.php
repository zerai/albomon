<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\Integration\CatalogRepository;

use Albomon\Catalog\Adapter\Persistence\CatalogRepository;
use Albomon\Catalog\Application\Model\CatalogItem;
use Albomon\Catalog\Application\Model\Exception\CatalogRepositoryException;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class CatalogRepositoryTest extends TestCase
{
    private const DEFAULT_FIXTURES_DIR = __DIR__ . '/Fixtures';

    private const DEFAULT_FIXTURES_FILENAME = '/test-catalog.json';

    private const FIRST_UUID = '7981d562-35ca-47a2-a855-a80339760acb';

    private const SECOND_UUID = '1ecd8953-9785-4f37-988a-8e83e9a12ddb';

    private const FIRST_ITEM_NAME = 'irrelevant';

    private const SECOND_ITEM_NAME = 'other irrelevant';

    private const FIRST_RSS_FEED_URL = 'https://first.irrelevant.feed';

    private const SECOND_RSS_FEED_URL = 'https://second.irrelevant.feed';

    protected function setUp(): void
    {
        /* reset json catalog file */
        $defaultCatalogFile = self::DEFAULT_FIXTURES_DIR . self::DEFAULT_FIXTURES_FILENAME;
        $jsonContent = json_encode([], JSON_PRETTY_PRINT);
        $fp = fopen($defaultCatalogFile, 'w');
        fwrite($fp, $jsonContent);
        fclose($fp);
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

    public function testThrowExceptionIfJsonCatalogFileDoesNotExist(): void
    {
        $expectedCatalogFile = self::DEFAULT_FIXTURES_DIR . '/notexist.json';
        self::expectException(CatalogRepositoryException::class);
        self::expectExceptionMessage("Expected catalog file '$expectedCatalogFile' not found.");

        new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/notexist.json');
    }

    public function testItReturnCatalogItems(): void
    {
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/test-preloaded-catalog.json');

        self::assertNotEquals([], $sut->getItems());
    }

    public function testItAddCatalogItem(): void
    {
        $item = CatalogItem::with(self::FIRST_UUID, self::FIRST_ITEM_NAME, self::FIRST_RSS_FEED_URL);
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, self::DEFAULT_FIXTURES_FILENAME);

        $sut->save($item);

        self::assertEquals(1, \count($sut->getItems()));
        self::assertFileExists(self::DEFAULT_FIXTURES_DIR . self::DEFAULT_FIXTURES_FILENAME);
    }

    public function testItUpdateExistingCatalogItem(): void
    {
        $item = CatalogItem::with(self::FIRST_UUID, self::FIRST_ITEM_NAME, self::FIRST_RSS_FEED_URL);
        $itemToUpdate = CatalogItem::with(self::FIRST_UUID, self::FIRST_ITEM_NAME, 'https://updated.catalog.item');
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, self::DEFAULT_FIXTURES_FILENAME);
        $sut->save($item);

        $sut->save($itemToUpdate);

        self::assertEquals(1, \count($sut->getItems()));
        self::assertEquals(
            [
                self::FIRST_UUID => [
                    self::FIRST_UUID,
                    self::FIRST_ITEM_NAME,
                    'https://updated.catalog.item',
                ],
            ],
            $sut->getItems()
        );
    }

    public function testItAddMultipleCatalogItem(): void
    {
        $itemFirst = CatalogItem::with(self::FIRST_UUID, self::FIRST_ITEM_NAME, self::FIRST_RSS_FEED_URL);
        $itemSecond = CatalogItem::with(self::SECOND_UUID, self::SECOND_ITEM_NAME, self::SECOND_RSS_FEED_URL);
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, self::DEFAULT_FIXTURES_FILENAME);

        $sut->save($itemFirst, $itemSecond);

        self::assertEquals(2, \count($sut->getItems()));
        self::assertFileExists(self::DEFAULT_FIXTURES_DIR . self::DEFAULT_FIXTURES_FILENAME);
    }

    public function testItCalculateTotalItemWhenEmptyCatalog(): void
    {
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/test-empty-catalog.json');

        self::assertEquals(0, $sut->totalItems());
    }

    public function testItCalculateTotalItemWhenOneItemInCatalog(): void
    {
        $itemFirst = CatalogItem::with(self::FIRST_UUID, self::FIRST_ITEM_NAME, self::FIRST_RSS_FEED_URL);
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, self::DEFAULT_FIXTURES_FILENAME);

        $sut->save($itemFirst);

        self::assertEquals(1, $sut->totalItems());
    }

    public function testItCalculateTotalItemWhenTwoItemInCatalog(): void
    {
        $itemFirst = CatalogItem::with(self::FIRST_UUID, self::FIRST_ITEM_NAME, self::FIRST_RSS_FEED_URL);
        $itemSecond = CatalogItem::with(self::SECOND_UUID, self::SECOND_ITEM_NAME, self::SECOND_RSS_FEED_URL);
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, self::DEFAULT_FIXTURES_FILENAME);

        $sut->save($itemFirst, $itemSecond);

        self::assertEquals(2, $sut->totalItems());
    }

    public function testItLoadAnEmptyCatalogFromFilesystem(): void
    {
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/test-empty-catalog.json');

        self::assertEquals([], $sut->getItems());
    }

    public function testItLoadAPreloadedCatalogFromFilesystem(): void
    {
        $sut = new CatalogRepository(self::DEFAULT_FIXTURES_DIR, '/test-preloaded-catalog.json');

        self::assertNotEquals([], $sut->getItems());
        self::assertEquals(2, \count($sut->getItems()));
    }
}
