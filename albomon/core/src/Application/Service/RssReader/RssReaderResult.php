<?php

declare(strict_types=1);

namespace Albomon\Core\Application\Service\RssReader;


/**
 * Class RssReaderResult
 * @package Albomon\Core\Application\Service\RssReader
 */
class RssReaderResult implements RssReaderResultInterface
{

    /** @var bool */
    private $httpStatus;

    /** @var string */
    private $httpError;

    /**
     * RssReaderResult constructor.
     * @param bool $httpStatus
     */
    public function __construct(bool $httpStatus)
    {
        $this->httpStatus = $httpStatus;
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

}