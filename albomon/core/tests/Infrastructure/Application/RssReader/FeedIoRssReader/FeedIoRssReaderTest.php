<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Infrastructure\Application\RssReader\FeedIoRssReader;

use Albomon\Core\Application\Service\RssReader\RssReaderInterface;
use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use Albomon\Core\Infrastructure\Application\RssReader\FeedIoRssReader\FeedIoRssReader;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FeedIoRssReaderTest extends TestCase
{
    private const FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml';

    private const OTHER_FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/other_feed.xml';

    private const WRONG_FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xmlllll';

    /** @test */
    public function itCanBeCreated(): void
    {
        $rssReader = new FeedIoRssReader();

        self::assertInstanceOf(RssReaderInterface::class, $rssReader);
    }

    /** @test */
    public function itCanChangeTargetUrl(): void
    {
        $rssReader = new FeedIoRssReader();

        $rssReader->setTargetUrl(self::FEED_URL);

        $rssReader->setTargetUrl(self::OTHER_FEED_URL);

        self::assertEquals(self::OTHER_FEED_URL, $rssReader->getTargetUrl());
    }

    /** @test */
    public function invalidTargetUrlThrowException(): void
    {
        self::expectException(InvalidArgumentException::class);
        $rssReader = new FeedIoRssReader();

        // TODO use a dataProvider check all case empty|no schema|invalid path
        $rssReader->setTargetUrl('www.invalid.url');
    }

    /** @test */
    public function itHandleExecution(): void
    {
        $rssReader = new FeedIoRssReader();

        $readerResult = $rssReader->execute(self::FEED_URL);

        self::assertInstanceOf(RssReaderResultInterface::class, $readerResult);
        self::assertTrue($readerResult->httpStatus());
        self::assertEquals(self::FEED_URL, $readerResult->feedUrl());
    }

    /** @test */
    public function itHandleInactiveFeed(): void
    {
        $rssReader = new FeedIoRssReader();

        $readerResult = $rssReader->execute(self::WRONG_FEED_URL);

        self::assertInstanceOf(RssReaderResultInterface::class, $readerResult);
        self::assertFalse($readerResult->httpStatus());
        self::assertEquals(self::WRONG_FEED_URL, $readerResult->feedUrl());
        self::assertNotNull($readerResult->httpError());
    }

    /** @test */
    public function itHandleXmlDom(): void
    {
        //self::markTestSkipped();
        $rssReader = new FeedIoRssReader();

        $readerResult = $rssReader->execute(self::FEED_URL);

        self::assertInstanceOf(RssReaderResultInterface::class, $readerResult);
        self::assertTrue($readerResult->httpStatus());
        self::assertNotNull($readerResult->xmlDocument());
    }
}
