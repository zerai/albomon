<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\Application\RssReader\FeedIoRssReader;

use Albomon\Core\Application\Service\RssReader\RssReaderInterface;
use Albomon\Core\Application\Service\RssReader\RssReaderResult;
use Albomon\Core\Application\Service\RssReader\RssReaderResultIllegalOperationException;
use Albomon\Core\Application\Service\RssReader\RssReaderResultInterface;
use FeedIo\FeedIo;
use FeedIo\Reader\ReadErrorException;
use FeedIo\Reader\Result;
use InvalidArgumentException;

class FeedIoRssReader implements RssReaderInterface
{
    private ?string $targetUrl = null;

    public function __construct(
        private readonly FeedIo $feedIo
    ) {
    }

    /**
     * @throws RssReaderResultIllegalOperationException
     */
    public function execute(string $targetUrl): RssReaderResultInterface
    {
        $this->setTargetUrl($targetUrl);

        return $this->readRss();
    }

    public function setTargetUrl(string $targetUrl): void
    {
        if (! filter_var($targetUrl, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException('Invalid target url in RssReaderService. Url was: ' . $targetUrl);
        }

        $this->targetUrl = $targetUrl;
    }

    public function getTargetUrl(): string
    {
        return $this->targetUrl;
    }

    /**
     * @return RssReaderResult
     *
     * @throws RssReaderResultIllegalOperationException
     */
    private function readRss()
    {
        try {
            $feed = $this->feedIo->read($this->targetUrl);

            //check http status code and content type before process
            if (200 === $feed->getResponse()->getStatusCode() && $feed->getDocument()->isXml()) {
                $rssReaderResult = new RssReaderResult(true, $this->targetUrl);

                $rssReaderResult->setXmlDocument($this->getDomDocument($feed));

                $rssReaderResult->setLastFeedItemDate($this->getLastFeedItemDate($feed));
            } else {
                $rssReaderResult = new RssReaderResult(false, $this->targetUrl);

                $rssReaderResult->setHttpError('HTTP error.');
            }

            return $rssReaderResult;
        } catch (ReadErrorException $exception) {
            $rssReaderResult = new RssReaderResult(false, $this->targetUrl);

            $rssReaderResult->setHttpError($exception->getMessage());

            return $rssReaderResult;
        }
    }

    private function getDomDocument(Result $rssReaderResult): ?\DOMDocument
    {
        if (! $rssReaderResult->getDocument()->isXml()) {
            return null;
        }

        return $rssReaderResult->getDocument()->getDOMDocument();
    }

    private function getLastFeedItemDate(Result $rssReaderResult): \DateTime
    {
        return $rssReaderResult->getFeed()->getLastModified();
    }
}
