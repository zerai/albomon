<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Infrastructure\UI\Cli\CliLogger;

use Albomon\Core\Infrastructure\UI\Cli\CliLoggerInterface\CliLogger;
use PHPUnit\Framework\MockObject\BadMethodCallException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Style\SymfonyStyle;

class CliLoggerTest extends TestCase
{
    private const DEFAULT_MESSAGE = 'default message';

    /** @test */
    public function itCanBeInstatiate(): void
    {
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        self::assertInstanceOf(CliLogger::class, $cliLogger);
    }

    /** @test */
    public function emergencyMethodShouldThrowException(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('CliLogger don\'t implement this method.');
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $cliLogger->emergency(self::DEFAULT_MESSAGE);
    }

    /** @test */
    public function alertMethodShouldThrowException(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('CliLogger don\'t implement this method.');
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $cliLogger->alert(self::DEFAULT_MESSAGE);
    }

    /** @test */
    public function criticalMethodShouldThrowException(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('CliLogger don\'t implement this method.');
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $cliLogger->critical(self::DEFAULT_MESSAGE);
    }

    /** @test */
    public function itCanLogError(): void
    {
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $io->expects($this->once())
            ->method('error')
            ->with(self::DEFAULT_MESSAGE);

        $cliLogger->error(self::DEFAULT_MESSAGE);
    }

    /** @test */
    public function itCanLogWarning(): void
    {
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $io->expects($this->once())
            ->method('warning')
            ->with(self::DEFAULT_MESSAGE);

        $cliLogger->warning(self::DEFAULT_MESSAGE);
    }

    /** @test */
    public function itCanLogNotice(): void
    {
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $io->expects($this->once())
            ->method('text')
            ->with(self::DEFAULT_MESSAGE);

        $cliLogger->notice(self::DEFAULT_MESSAGE);
    }

    /** @test */
    public function itCanLogInfo(): void
    {
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $io->expects($this->once())
            ->method('text')
            ->with(self::DEFAULT_MESSAGE);

        $cliLogger->info(self::DEFAULT_MESSAGE);
    }

    /** @test */
    public function debugMethodShouldThrowException(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('CliLogger don\'t implement this method.');
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $cliLogger->debug(self::DEFAULT_MESSAGE);
    }

    public function it_can_log_generic_message(): void
    {
        $io = $this->createMock(SymfonyStyle::class);
        $cliLogger = new CliLogger($io);

        $io->expects($this->once())
            ->method('log')
            ->with(self::DEFAULT_MESSAGE);

        $cliLogger->log('xxx', self::DEFAULT_MESSAGE);
    }
}
