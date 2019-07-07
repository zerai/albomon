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

class FeedIoRssReader implements RssReaderInterface
{
    /** @var FeedIo */
    private $feedIo;

    /** @var string */
    private $targetUrl;

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

    public function readRss()
    {
        try {
            $result = $this->feedIo->read($this->targetUrl);

            //$transformerResult = $this->resultTrasformer($result);

            return $result;
        } catch (ReadErrorException $exception) {
            // TODO log in file?
            // TODO put in STDOUT
            //$this->logger->error('Error appear during user creation. Reason: ' . $exception->getMessage());
            //echo 'Error ...... ';

            $rssReaderResult = new RssReaderResult(false);
            $rssReaderResult->setHttpError($exception->getMessage());

            return $rssReaderResult;
        }
    }

//    /**
//     * @param Result $result
//     * @return RssReaderResult
//     */
//    public function resultTrasformer(Result $result): RssReaderResult
//    {
//
//        //TODO remove param
//        $rssReaderResult = new RssReaderResult( true);
//
//        return $rssReaderResult;
//    }
//
}
