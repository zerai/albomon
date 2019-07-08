<?php

declare(strict_types=1);

namespace Albomon\Core\Application\MonitorApplicationService;

use Albomon\Core\Application\Service\RssReader\RssReaderInterface;
use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;

class MonitorApplicationService
{
    /** @var RssReaderInterface */
    private $feedReader;

    /**
     * MonitorApplicationService constructor.
     *
     * @param RssReaderInterface $feedReader
     */
    public function __construct(RssReaderInterface $feedReader)
    {
        $this->feedReader = $feedReader;
    }

    public function checkAlbo(string $alboUrl): RssReaderResultInterface
    {
        $readerResult = $this->feedReader->execute($alboUrl);

        // TODO
        // persist history records?
        // build MonitorRepositoryResult object
        // logging InactiveFeedDetection event...

        return $readerResult;
    }

    public function checkAlboList(array $alboList): array
    {
        $resultCollection = [];

        foreach ($alboList as $alboUrl) {
            $resultCollection[] = $this->checkAlbo($alboUrl);
        }

        return $resultCollection;
    }
}
