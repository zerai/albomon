<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Application\Service\RssReader;


use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use PHPUnit\Framework\TestCase;

class RssReaderResultTest extends TestCase
{
    /** @test */
    public function it_can_be_created(): void
    {
        $httpStatus = true;

        $rssReaderResult = new RssReaderResult($httpStatus);

        self::assertInstanceOf(RssReaderResultInterface::class, $rssReaderResult);
    }

    /** @test */
    public function it_return_http_status(): void
    {
        $httpStatus = true;

        $rssReaderResult = new RssReaderResult($httpStatus);

        self::assertEquals($httpStatus, $rssReaderResult->httpStatus());
    }

    /** @test */
    public function it_can_add_http_error(): void
    {
        $httpStatus = false;

        $httpError = 'Not Found.';

        $rssReaderResult = new RssReaderResult($httpStatus);

        $rssReaderResult->setHttpError($httpError);

        self::assertEquals($httpError, $rssReaderResult->httpError());
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function it_cant_add_http_error_when_httpStatus_is_true(): void
    {
        // TODO
        self::markTestSkipped("implement in code");

        $httpStatus = true;

        $httpError = 'Not Found.';

        $rssReaderResult = new RssReaderResult($httpStatus);

        $rssReaderResult->setHttpError($httpError);
    }

}