<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Application\Service\RssReader;

use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use Albomon\Core\Application\Service\RssReader\RssReaderResultIllegalOperationException;
use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use DOMDocument;
use PHPUnit\Framework\TestCase;

class RssReaderResultTest extends TestCase
{
    private const FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml';

    /** @test */
    public function itCanBeCreated(): void
    {
        $httpStatus = true;

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        self::assertInstanceOf(RssReaderResultInterface::class, $rssReaderResult);
    }

    /** @test */
    public function itReturnHttpStatus(): void
    {
        $httpStatus = true;

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        self::assertEquals($httpStatus, $rssReaderResult->httpStatus());
    }

    /** @test */
    public function itCanAddHttpError(): void
    {
        $httpStatus = false;

        $httpError = 'Not Found.';

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setHttpError($httpError);

        self::assertEquals($httpError, $rssReaderResult->httpError());
    }

    /** @test */
    public function itCanAddXmlDocument(): void
    {
        $httpStatus = true;
        $xmlDocument = new DOMDocument('1.0', 'ISO-8859-15');

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setXmlDocument($xmlDocument);

        self::assertEquals($xmlDocument, $rssReaderResult->xmlDocument());
    }

    /** @test */
    public function itCanAddLastItemFeedDate(): void
    {
        $httpStatus = true;

        $date = new \DateTime('now');

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setLastFeedItemDate($date);

        self::assertEquals($date, $rssReaderResult->lastFeedItemDate());
    }

    /** @test */
    public function itCantSetHttpErrorOnActiveFeed(): void
    {
        self::expectException(RssReaderResultIllegalOperationException::class);
        $httpStatus = true;

        $httpError = 'Not Found.';

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setHttpError($httpError);
    }

    /** @test */
    public function itCantSetLastFeedDateOnInactiveFeed(): void
    {
        self::expectException(RssReaderResultIllegalOperationException::class);
        $httpStatus = false;

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setLastFeedItemDate(new \DateTime('now'));
    }

    /** @test */
    public function itCantSetXmlDocumentOnInactiveFeed(): void
    {
        self::expectException(RssReaderResultIllegalOperationException::class);
        $httpStatus = false;

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setXmlDocument(new DOMDocument('1.0', 'ISO-8859-15'));
    }

    /** @test */
    public function unsetPropertyXmlDocumentShouldReturnNull(): void
    {
        $httpStatus = false;

        $rssReaderResult = new RssReaderResult($httpStatus, 'http://fake-feeds.fake-feeds.com/');

        self::assertNull($rssReaderResult->xmlDocument());
    }
}
