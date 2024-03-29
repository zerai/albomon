<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\CliLoggerInterface;

use PHPUnit\Framework\MockObject\BadMethodCallException;
use Symfony\Component\Console\Style\SymfonyStyle;

class CliLogger implements CliLoggerInterface
{
    private const BAD_METHOD_CALL_EXCEPTION_MESSAGE = 'CliLogger don\'t implement this method.';

    public function __construct(
        private readonly SymfonyStyle $io
    ) {
    }

    /**
     * System is unusable.
     *
     * @param string $message
     */
    public function emergency($message, array $context = []): void
    {
        throw new BadMethodCallException(self::BAD_METHOD_CALL_EXCEPTION_MESSAGE);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     */
    public function alert($message, array $context = []): void
    {
        throw new BadMethodCallException(self::BAD_METHOD_CALL_EXCEPTION_MESSAGE);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     */
    public function critical($message, array $context = []): void
    {
        throw new BadMethodCallException(self::BAD_METHOD_CALL_EXCEPTION_MESSAGE);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     */
    public function error($message, array $context = []): void
    {
        $this->io->error($message);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     */
    public function warning($message, array $context = []): void
    {
        $this->io->warning($message);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     */
    public function notice($message, array $context = []): void
    {
        $this->io->text($message);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     */
    public function info($message, array $context = []): void
    {
        $this->io->text($message);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     */
    public function debug($message, array $context = []): void
    {
        throw new BadMethodCallException(self::BAD_METHOD_CALL_EXCEPTION_MESSAGE);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     */
    public function log($level, $message, array $context = []): void
    {
        $this->io->text($message);
    }
}
