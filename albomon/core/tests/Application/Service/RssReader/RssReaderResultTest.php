<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Application\Service\RssReader;

use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use DOMDocument;
use PHPUnit\Framework\TestCase;

class RssReaderResultTest extends TestCase
{
    private const FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml';

    /** @test */
    public function it_can_be_created(): void
    {
        $httpStatus = true;

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        self::assertInstanceOf(RssReaderResultInterface::class, $rssReaderResult);
    }

    /** @test */
    public function it_return_http_status(): void
    {
        $httpStatus = true;

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        self::assertEquals($httpStatus, $rssReaderResult->httpStatus());
    }

    /** @test */
    public function it_can_add_http_error(): void
    {
        $httpStatus = false;

        $httpError = 'Not Found.';

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setHttpError($httpError);

        self::assertEquals($httpError, $rssReaderResult->httpError());
    }

    /** @test */
    public function it_can_add_xml_document(): void
    {
        $httpStatus = true;
        $xmlDocument = new DOMDocument('1.0', 'ISO-8859-15');

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setXmlDocument($xmlDocument);

        self::assertEquals($xmlDocument, $rssReaderResult->xmlDocument());
    }

    /** @test */
    public function it_can_add_last_item_feed_date(): void
    {
        $httpStatus = true;

        $date = new \DateTime('now');

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setlastFeedItemDate($date);

        self::assertEquals($date, $rssReaderResult->lastFeedItemDate());
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function it_cant_add_http_error_when_httpStatus_is_true(): void
    {
        // TODO
        self::markTestSkipped('implement in code');

        $httpStatus = true;

        $httpError = 'Not Found.';

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setHttpError($httpError);
    }
}
