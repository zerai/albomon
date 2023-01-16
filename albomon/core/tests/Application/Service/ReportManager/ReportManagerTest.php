<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Application\Service\ReportManager;

use Albomon\Core\Application\Service\ReportManager\ReportManager;
use Albomon\Core\Application\Service\ReportManager\ReportManagerInterface;
use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class ReportManagerTest extends TestCase
{
    private const REPORT_FILE_NAME = 'albomon-report';
    /**
     * @var vfsStreamDirectory
     */
    private $root;

    /**
     * set up test environmemt.
     */
    public function setUp(): void
    {
        $this->root = vfsStream::setup('exampleDir');
    }

    /** @test */
    public function it_can_create(): void
    {
        self::assertInstanceOf(ReportManagerInterface::class, new ReportManager('irrelevantDirectory/'));
    }

    /** @test */
    public function it_can_return_report_filename(): void
    {
        $directory = 'directory/sub-directory';

        $repoManager = new ReportManager($directory);

        self::assertEquals($directory.DIRECTORY_SEPARATOR.self::REPORT_FILE_NAME.'.csv', $repoManager->reportFilename());
    }

    /** @test */
    public function it_can_add_item_to_report(): void
    {
        $reportDataItem = new RssReaderResult(
            true,
            'http://feed.irrelevant.com/1');
        $reportDataItem->setLastFeedItemDate(new \DateTime('now'));

        $newReportDataItem = new RssReaderResult(
            true,
            'http://feed.irrelevant.com/new');
        $newReportDataItem->setLastFeedItemDate(new \DateTime('now'));

        $reportManager = new ReportManager('directory');

        $reportManager->addReportItem($newReportDataItem);

        self::assertInstanceOf(ReportManagerInterface::class, $reportManager);
    }

    /** @test */
    public function it_can_add_itemCollection_to_report(): void
    {
        self::markTestSkipped();
    }

    /** @test */
    public function it_can_generate_report(): void
    {
        $reportDataItem = new RssReaderResult(
            true,
            'http://feed.irrelevant.com/1');
        $reportDataItem->setLastFeedItemDate(new \DateTime('now'));

        $reportManager = new ReportManager(vfsStream::url('exampleDir'));

        $reportManager->addReportItem($reportDataItem);

        $reportManager->generateReport();

        $this->assertTrue($this->root->hasChild('albomon-report.csv'));
    }
}
