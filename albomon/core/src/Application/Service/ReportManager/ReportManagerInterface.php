<?php

declare(strict_types=1);

namespace Albomon\Core\Application\Service\ReportManager;

use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;

interface ReportManagerInterface
{
    public function generateReport(): void;

    public function addReportItem(RssReaderResultInterface $item): void;

    public function addReportItemCollection(array $itemCollection): void;
}
