<?php

declare(strict_types=1);

namespace Albomon\Core\Application\Service\RssReader;

use RuntimeException;

/**
 * Class RssReaderResult.
 */
class RssReaderResult implements RssReaderResultInterface
{
    /** @var bool */
    private $httpStatus;

    /** @var string */
    private $httpError;

    /** @var string */
    private $feedUrl;

    /** @var \DOMDocument */
    private $xmlDocument;

    /** @var \DateTime */
    private $lastFeedItemDate;

    /**
     * RssReaderResult constructor.
     *
     * @param bool   $httpStatus
     * @param string $feedUrl
     */
    public function __construct(bool $httpStatus, string $feedUrl)
    {
        $this->httpStatus = $httpStatus;
        $this->feedUrl = $feedUrl;
    }

    /**
     * @return bool
     */
    public function httpStatus(): bool
    {
        return $this->httpStatus;
    }

    /**
     * @return string
     */
    public function httpError(): string
    {
        return $this->httpError;
    }

    /**
     * @param string $httpError
     */
    public function setHttpError(string $httpError): void
    {
        if ($this->isActiveFeed()) {
            throw new RuntimeException('Can\'t set httpError property in active feed');
        }
        $this->httpError = $httpError;
    }

    /**
     * @return string
     */
    public function feedUrl(): string
    {
        return $this->feedUrl;
    }

    public function setXmlDocument(\DOMDocument $xmlDocument): void
    {
        if (!$this->isActiveFeed()) {
            throw new RuntimeException('Can\'t set xml property on inactive feed');
        }
        $this->xmlDocument = $xmlDocument;
    }

    /** @return \DOMDocument */
    public function xmlDocument(): \DOMDocument
    {
        return $this->xmlDocument;
    }

    public function setlastFeedItemDate($lastFeedItemDate): void
    {
        if (!$this->isActiveFeed()) {
            throw new RuntimeException('Can\'t set lastFeedItemDate property on inactive feed');
        }
        $this->lastFeedItemDate = $lastFeedItemDate;
    }

    /** @return \DateTime */
    public function lastFeedItemDate(): \DateTime
    {
        return $this->lastFeedItemDate;
    }

    private function isActiveFeed(): bool
    {
        return $this->httpStatus;
    }
}
