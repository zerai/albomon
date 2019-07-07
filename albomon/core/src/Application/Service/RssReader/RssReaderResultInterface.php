<?php

declare(strict_types=1);

namespace Albomon\Core\Application\Service\RssReader;


/**
 * Interface RssReaderResultInterface
 * @package Albomon\Core\Application\Service\RssReader
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
}