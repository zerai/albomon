<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Traits;

use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use Symfony\Component\Console\Helper\Table;

trait AlboResultStyleTrait
{
    protected function formatContentUpdatedAt(\DateTime $contenteDateTime): string
    {
        $dateNow = new \DateTime('now');

        $diff = $dateNow->diff($contenteDateTime)->days;

        return $contenteDateTime->format('Y-m-d').'  -'.$diff.' gg.';
    }

    protected function formatTableRow(RssReaderResultInterface $monitorResult, Table $table): Table
    {
        if (!$monitorResult->httpStatus()) {
            $table->addRow([$monitorResult->feedUrl(), \sprintf('<error>%s</error>', 'NON ATTIVO'), self::XML_SPEC_VALIDATION, '', 'server error']);
        } else {
            $lastFeedItemDateWithDifference = $this->formatContentUpdatedAt($monitorResult->lastFeedItemDate());

            $table->addRow([$monitorResult->feedUrl(), 'ATTIVO', self::XML_SPEC_VALIDATION, $lastFeedItemDateWithDifference, '']);
        }

        return $table;
    }
}
