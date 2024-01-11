<?php declare(strict_types=1);

namespace Albomon\Core\Application\Service\ReportManager;

use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use DateTime;
use League\Csv\Writer;

class ReportManager implements ReportManagerInterface
{
    private const REPORT_FILE_NAME = 'albomon-report';

    private const XML_SPEC_VALIDATION = 'NON RILEVATO';

    private array $reportData;

    public function __construct(
        private readonly ?string $reportDir,
    ) {
        $this->reportData = [];
    }

    public function generateReport(): void
    {
        $outputFile = $this->reportFilename();

        $writer = Writer::createFromPath($outputFile, 'w+');

        $writer->insertOne(['Feed', 'Feed_status', 'Spec_status', 'Content_Updated_At', 'Error']);

        foreach ($this->reportData as $alboResult) {
            $writer->insertOne([
                $alboResult->feedUrl(),
                $alboResult->httpStatus() ? 'ATTIVO' : 'NON ATTIVO',
                self::XML_SPEC_VALIDATION,
                $alboResult->httpStatus() ? $this->formatContentUpdatedAt($alboResult->lastFeedItemDate()) : '',
                $alboResult->httpStatus() ? '' : $alboResult->httpError(),
            ]);
        }
    }

    public function addReportItem(RssReaderResultInterface $item): void
    {
        $this->reportData[] = $item;
    }

    public function addReportItemCollection(array $itemCollection): void
    {
        $this->reportData = $itemCollection;
    }

    public function reportFilename(): string
    {
        return $this->reportDir . DIRECTORY_SEPARATOR . self::REPORT_FILE_NAME . '.csv';
    }

    private function formatContentUpdatedAt(DateTime $contenteDateTime): string
    {
        $dateNow = new DateTime('now');

        $diff = $dateNow->diff($contenteDateTime)->days;

        return $contenteDateTime->format('Y-m-d') . '  -' . $diff . ' gg.';
    }
}
