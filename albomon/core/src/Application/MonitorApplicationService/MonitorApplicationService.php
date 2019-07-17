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
        return $this->feedReader->execute($alboUrl);
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
