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

        $rssReaderResult->setLastFeedItemDate($date);

        self::assertEquals($date, $rssReaderResult->lastFeedItemDate());
    }

    /**
     * @test
     * @expectedException \Albomon\Core\Application\Service\RssReader\RssReaderResultIllegalOperationException
     */
    public function it_cant_set_http_error_on_active_feed(): void
    {
        $httpStatus = true;

        $httpError = 'Not Found.';

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setHttpError($httpError);
    }

    /**
     * @test
     * @expectedException \Albomon\Core\Application\Service\RssReader\RssReaderResultIllegalOperationException
     */
    public function it_cant_set_last_feed_date_on_inactive_feed(): void
    {
        $httpStatus = false;

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setLastFeedItemDate(new \DateTime('now'));
    }

    /**
     * @test
     * @expectedException \Albomon\Core\Application\Service\RssReader\RssReaderResultIllegalOperationException
     */
    public function it_cant_set_xml_document_on_inactive_feed(): void
    {
        $httpStatus = false;

        $rssReaderResult = new RssReaderResult($httpStatus, self::FEED_URL);

        $rssReaderResult->setXmlDocument(new DOMDocument('1.0', 'ISO-8859-15'));
    }

    /** @test */
    public function unset_property_xmlDocument_should_return_null(): void
    {
        $httpStatus = false;

        $rssReaderResult = new RssReaderResult($httpStatus, 'http://fake-feeds.fake-feeds.com/');

        self::assertNull($rssReaderResult->xmlDocument());
    }
}
