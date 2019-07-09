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
        $this->xmlDocument = $xmlDocument;
    }

    /** @return \DOMDocument */
    public function xmlDocument(): \DOMDocument
    {
        return $this->xmlDocument;
    }
}
