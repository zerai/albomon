<?php declare(strict_types=1);

namespace Albomon\Core\Application\MonitorApplicationService;

use Albomon\Core\Application\Service\RssReader\RssReaderInterface;
use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use Psr\Log\LoggerInterface;

class MonitorApplicationService
{
    public function __construct(
        private RssReaderInterface $feedReader,
        private LoggerInterface $logger,
    ) {
    }

    public function checkAlbo(string $alboUrl): RssReaderResultInterface
    {
        $this->logger->info(
            'Check albo feed: ' . $alboUrl,
            []
        );

        /** @var RssReaderResult $result */
        $result = $this->feedReader->execute($alboUrl);

        if (! $result->httpStatus()) {
            $this->logger->info(
                'Check failed for albo: ' . $alboUrl,
                []
            );
        }

        return $result;
    }

    public function checkAlboList(array $alboList): array
    {
        $resultCollection = [];

        foreach ($alboList as $alboUrl) {
            foreach ($alboUrl as $valueUrl) {
                $resultCollection[] = $this->checkAlbo($valueUrl);
            }
        }

        return $resultCollection;
    }
}
