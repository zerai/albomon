<?php

declare(strict_types=1);

namespace Albomon\Core\Application\Service\RssReader;

/**
 * Interface RssReaderResultInterface.
 */
interface RssReaderResultInterface
{
    /**
     * @return bool
     */
    public function httpStatus(): bool;

    /**
     * @return string
     */
    public function httpError(): string;

    /**
     * @return string
     */
    public function feedUrl(): string;

    /** @return \DOMDocument */
    public function xmlDocument(): \DOMDocument;

    /** @return \DateTime */
    public function lastFeedItemDate(): \DateTime;
}
