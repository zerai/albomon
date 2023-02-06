<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\Unit\Model;

use Albomon\Catalog\Application\Model\CatalogItem;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class CatalogItemTest extends TestCase
{
    private const IDENTITY = '29a042da-5e75-4490-8b64-6e2d86176180';

    private const RSS_FEED_URL = 'https://www.foobar.example/feed.xml';

    private const ITEM_NAME = 'irrelevant';

    public function testShouldHaveAnIdentity(): void
    {
        $item = CatalogItem::with(self::IDENTITY, self::ITEM_NAME, self::RSS_FEED_URL);

        self::assertNotEmpty($item->identity());
    }

    public function testShouldHaveAName(): void
    {
        $item = CatalogItem::with(self::IDENTITY, self::ITEM_NAME, self::RSS_FEED_URL);

        self::assertNotEmpty($item->name());
    }

    public function testShouldHaveAnRssFeed(): void
    {
        $item = CatalogItem::with(self::IDENTITY, self::ITEM_NAME, self::RSS_FEED_URL);

        self::assertNotEmpty($item->rssFeedUrl());
    }

    /**
     * @dataProvider invalidIdentityDataProvider
     */
    public function testThrowExceptionWhenInvalidIdentity(string $identity, string $expectedExceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($expectedExceptionMessage);

        CatalogItem::with($identity, self::ITEM_NAME, self::RSS_FEED_URL);
    }

    public function invalidIdentityDataProvider(): array
    {
        return [

            ['', 'Catalog item must have an identifier'],
            ['abcd', 'Catalog item identity should be an uuid. Got "abcd"'],
        ];
    }

    /**
     * @dataProvider invalidItemNameDataProvider
     */
    public function testThrowExceptionWhenInvalidItemName(string $name, string $expectedExceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($expectedExceptionMessage);

        CatalogItem::with(self::IDENTITY, $name, self::RSS_FEED_URL);
    }

    public function invalidItemNameDataProvider(): array
    {
        return [

            ['', 'Catalog item must have a name'],
        ];
    }

    /**
     * @dataProvider invalidRssFeedUrlDataProvider
     */
    public function testThrowExceptionWhenInvalidRssFeedUrl(string $rssFeedUrl, $expectedExceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($expectedExceptionMessage);

        CatalogItem::with(self::IDENTITY, self::ITEM_NAME, $rssFeedUrl);
    }

    public function invalidRssFeedUrlDataProvider(): array
    {
        return [
            ['', 'Catalog item must have an rss feed url'],
            ['invalid url', 'Expected a rss feed url value to be a valid URL'],
            ['http://www.example.com/a-feed with-space.xml', 'Expected a rss feed url value to be a valid URL'],
        ];
    }
}
