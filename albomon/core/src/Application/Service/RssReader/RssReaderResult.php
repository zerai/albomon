<?php

declare(strict_types=1);

namespace Albomon\Core\Application\Service\RssReader;

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
     *
     * @throws RssReaderResultIllegalOperationException
     */
    public function setHttpError(string $httpError): void
    {
        if ($this->isActiveFeed()) {
            throw new RssReaderResultIllegalOperationException('HttpError property cannot be set.');
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

    /**
     * @param \DOMDocument $xmlDocument
     *
     * @throws RssReaderResultIllegalOperationException
     */
    public function setXmlDocument(\DOMDocument $xmlDocument): void
    {
        if (!$this->isActiveFeed()) {
            throw new RssReaderResultIllegalOperationException('XmlDocument property cannot be set.');
        }
        $this->xmlDocument = $xmlDocument;
    }

    /** @return \DOMDocument|null */
    public function xmlDocument(): ?\DOMDocument
    {
        return $this->xmlDocument;
    }

    /**
     * @param \DateTime $lastFeedItemDate
     *
     * @throws RssReaderResultIllegalOperationException
     */
    public function setLastFeedItemDate(\DateTime $lastFeedItemDate): void
    {
        if (!$this->isActiveFeed()) {
            throw new RssReaderResultIllegalOperationException('LastFeedItemDate property cannot be set.');
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
