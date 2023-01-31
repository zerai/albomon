<?php declare(strict_types=1);

namespace Albomon\Core\Application\Service\RssReader;

class RssReaderResult implements RssReaderResultInterface
{
    private ?string $httpError = null;

    private ?\DOMDocument $xmlDocument = null;

    private ?\DateTime $lastFeedItemDate = null;

    public function __construct(
        private bool $httpStatus,
        private string $feedUrl,
    ) {
    }

    public function httpStatus(): bool
    {
        return $this->httpStatus;
    }

    public function httpError(): string
    {
        return $this->httpError;
    }

    /**
     * @throws RssReaderResultIllegalOperationException
     */
    public function setHttpError(string $httpError): void
    {
        if ($this->isActiveFeed()) {
            throw new RssReaderResultIllegalOperationException('HttpError property cannot be set.');
        }
        $this->httpError = $httpError;
    }

    public function feedUrl(): string
    {
        return $this->feedUrl;
    }

    /**
     * @throws RssReaderResultIllegalOperationException
     */
    public function setXmlDocument(\DOMDocument $xmlDocument): void
    {
        if (! $this->isActiveFeed()) {
            throw new RssReaderResultIllegalOperationException('XmlDocument property cannot be set.');
        }
        $this->xmlDocument = $xmlDocument;
    }

    public function xmlDocument(): ?\DOMDocument
    {
        return $this->xmlDocument;
    }

    /**
     * @throws RssReaderResultIllegalOperationException
     */
    public function setLastFeedItemDate(\DateTime $lastFeedItemDate): void
    {
        if (! $this->isActiveFeed()) {
            throw new RssReaderResultIllegalOperationException('LastFeedItemDate property cannot be set.');
        }
        $this->lastFeedItemDate = $lastFeedItemDate;
    }

    public function lastFeedItemDate(): \DateTime
    {
        return $this->lastFeedItemDate;
    }

    private function isActiveFeed(): bool
    {
        return $this->httpStatus;
    }
}
