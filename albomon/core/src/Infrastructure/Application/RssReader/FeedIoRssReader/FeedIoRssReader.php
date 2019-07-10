<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\Application\RssReader\FeedIoRssReader;

use Albomon\Core\Application\Service\RssReader\RssReaderInterface;
use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use FeedIo\FeedIo;
use FeedIo\Reader\ReadErrorException;
use FeedIo\Reader\Result;
use InvalidArgumentException;

/**
 * Class FeedIoRssReader.
 */
class FeedIoRssReader implements RssReaderInterface
{
    /** @var FeedIo */
    private $feedIo;

    /** @var string */
    private $targetUrl;

    /**
     * FeedIoRssReader constructor.
     */
    public function __construct()
    {
        $this->feedIo = \FeedIo\Factory::create()->getFeedIo();
    }

    /**
     * @param string $targetUrl
     *
     * @return RssReaderResultInterface
     */
    public function execute(string $targetUrl): RssReaderResultInterface
    {
        $this->setTargetUrl($targetUrl);

        $rssReaderResult = $this->readRss();

        return $rssReaderResult;
    }

    /**
     * @param string $targetUrl
     */
    public function setTargetUrl(string $targetUrl): void
    {
        if (!filter_var($targetUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid target url in RssReaderService. Url was: '.$targetUrl);
        }

        $this->targetUrl = $targetUrl;
    }

    /**
     * @return string
     */
    public function getTargetUrl(): string
    {
        return $this->targetUrl;
    }

    private function readRss()
    {
        try {
            $result = $this->feedIo->read($this->targetUrl);

            $rssReaderResult = new RssReaderResult(true, $this->targetUrl);

            // TODO assign xml to result object
            $rssReaderResult->setXmlDocument($this->getDomDocument($result));

            return $rssReaderResult;
        } catch (ReadErrorException $exception) {
            // TODO log in file?
            //$this->logger->error('Error appear during user creation. Reason: ' . $exception->getMessage());

            $rssReaderResult = new RssReaderResult(false, $this->targetUrl);
            $rssReaderResult->setHttpError($exception->getMessage());

            return $rssReaderResult;
        }
    }

    private function getDomDocument(Result $rssReaderResult): ?\DOMDocument
    {
        if (!$rssReaderResult->getDocument()->isXml()) {
            return null;
        }

        return $rssReaderResult->getDocument()->getDOMDocument();
    }
}
