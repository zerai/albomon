<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Application\MonitorApplicationService;

use Albomon\Core\Application\MonitorApplicationService\MonitorApplicationService;
use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use Albomon\Core\Infrastructure\Application\RssReader\FeedIoRssReader\FeedIoRssReader;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class MonitorApplicationServiceTest extends TestCase
{
    private const FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml';

    private MonitorApplicationService $monitorApplicationService;

    /**
     * @var FeedIoRssReader
     */
    private $feedReader;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function setUp(): void
    {
        $this->feedReader = $this->createMock(FeedIoRssReader::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->monitorApplicationService = new monitorApplicationService($this->feedReader, $this->logger);
    }

    /**
     * @test
     */
    public function it_can_check_a_single_albo(): void
    {
        $rssPositiveResult = new RssReaderResult(true, self::FEED_URL);

        $this->feedReader->method('execute')
            ->willReturn($rssPositiveResult);

        $monitorResponse = $this->monitorApplicationService->checkAlbo(self::FEED_URL);

        self::assertInstanceOf(RssReaderResult::class, $monitorResponse);

        self::assertEquals($rssPositiveResult, $monitorResponse);
    }

    /**
     * @test
     */
    public function it_can_handle_error_on_check_a_single_albo(): void
    {
        $url = 'http://feeds.xxxxxx.it/xxxxx/xxxxx.xml';

        $rssNegativeResult = new RssReaderResult(false, self::FEED_URL);
        $rssNegativeResult->setHttpError('Not Found');

        $this->feedReader->method('execute')
            ->willReturn($rssNegativeResult);

        $monitorResponse = $this->monitorApplicationService->checkAlbo($url);

        self::assertInstanceOf(RssReaderResult::class, $monitorResponse);

        self::assertEquals($rssNegativeResult, $monitorResponse);
    }

    /**
     * @test
     */
    public function it_can_check_a_multiple_albo(): void
    {
        $alboList = [
            [
                'Muccia' => self::FEED_URL,
            ],
            [
                'Muccia' => self::FEED_URL,
            ],
        ];

        $this->feedReader->expects($this->exactly(2))->method('execute');

        $monitorResponse = $this->monitorApplicationService->checkAlboList($alboList);

        self::assertIsArray($monitorResponse);
    }
}
