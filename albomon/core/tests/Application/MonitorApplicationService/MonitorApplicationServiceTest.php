<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Application\MonitorApplicationService;

use Albomon\Core\Application\MonitorApplicationService\MonitorApplicationService;
use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use Albomon\Core\Infrastructure\Application\RssReader\FeedIoRssReader\FeedIoRssReader;
use PHPUnit\Framework\TestCase;

class MonitorApplicationServiceTest extends TestCase
{
    private const FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml';

    /** @var MonitorApplicationService */
    private $monitorApplicationService;

    /** @var FeedIoRssReader */
    private $feedReader;

    public function setUp()
    {
        $this->feedReader = $this->createMock(FeedIoRssReader::class);
        $this->monitorApplicationService = new monitorApplicationService($this->feedReader);
    }

    /** @test */
    public function it_can_check_a_single_albo(): void
    {
        $url = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml';

        $rssPositiveResult = new RssReaderResult(true, self::FEED_URL);

        $this->feedReader->method('execute')
            ->willReturn($rssPositiveResult);

        $monitorResponse = $this->monitorApplicationService->checkAlbo($url);

        self::assertInstanceOf(RssReaderResult::class, $monitorResponse);

        self::assertEquals($rssPositiveResult, $monitorResponse);
    }

    /** @test */
    public function it_can_handle_error_on_check_a_single_albo(): void
    {
        $url = 'http://feeds.xxxxxx.it/xxxxx/xxxxx.xml';

        $rssNegativeResult = new RssReaderResult(false, self::FEED_URL);
        $rssNegativeResult->setHttpError('Not Found');

        $this->feedReader->method('execute')
            ->willReturn($rssNegativeResult);

        $monitorResponse = $this->monitorApplicationService->checkAlbo($url);

        self::assertInstanceOf(RssReaderResult::class, $monitorResponse);

        self::assertEquals($rssNegativeResult, $rssNegativeResult);
    }

    /** @test */
    public function it_can_check_a_multiple_albo(): void
    {
        $alboList = [
            ['Muccia' => 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml'],
            ['Muccia' => 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml'],
        ];

        $this->feedReader->expects($this->exactly(2))->method('execute');

        $monitorResponse = $this->monitorApplicationService->checkAlboList($alboList);

        self::assertInternalType('array', $monitorResponse);
    }
}
