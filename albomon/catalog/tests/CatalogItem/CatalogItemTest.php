<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\CatalogItem;

use Albomon\Catalog\Application\Model\CatalogItem;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class CatalogItemTest extends TestCase
{
    private const IDENTITY = '29a042da-5e75-4490-8b64-6e2d86176180';

    private const RSS_FEED_URL = 'irrelevant_rss_url';

    public function testShouldHaveIdentityAndRssFeed(): void
    {
        $item = new CatalogItem(self::IDENTITY, self::RSS_FEED_URL);

        self::assertNotEmpty($item->identity());
        self::assertNotEmpty($item->rssFeedUrl());
    }

    /**
     * @dataProvider invalidIdentityDataProvider
     */
    public function testThrowExceptionWhenInvalidIdentity(string $identity, string $expectedExceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($expectedExceptionMessage);

        CatalogItem::with($identity, self::RSS_FEED_URL);
    }

    public function invalidIdentityDataProvider(): array
    {
        return [

            ['', 'Catalog item must have an identifier'],
            ['abcd', 'Catalog item identity should be an uuid. Got "abcd"'],
        ];
    }

    /**
     * @dataProvider invalidRssFeedUrlDataProvider
     */
    public function testThrowExceptionWhenInvalidRssFeedUrl(string $rssFeedUrl, $expectedExceptionMessage): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage($expectedExceptionMessage);

        CatalogItem::with(self::IDENTITY, $rssFeedUrl);
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
