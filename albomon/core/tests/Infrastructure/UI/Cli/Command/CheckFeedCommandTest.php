<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Infrastructure\UI\Cli\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CheckFeedCommandTest extends KernelTestCase
{
    private const FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml';

    private const WRONG_FEED_URL = 'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xmlllll';

    /**
     * @var CommandTester|null
     */
    private $commandTester;

    /**
     * @var Command
     */
    private $command;

    protected function setUp(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $this->command = $application->find('albomon:check:feed');
        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * @test
     */
    public function it_can_execute(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            // pass arguments to the helper
            'feed_url' => self::FEED_URL,
            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ]);

        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('Inizio scansione feed albo...', $output);
        $this->assertStringContainsString('AlboPOP Spec. Validation', $output);
    }

    /**
     * @test
     */
    public function it_can_execute_with_wrong_url(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            // pass arguments to the helper
            'feed_url' => self::WRONG_FEED_URL,
            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ]);

        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('Inizio scansione feed albo...', $output);
        $this->assertStringContainsString('NON ATTIVO', $output);
    }

    protected function tearDown(): void
    {
        $this->commandTester = null;
    }
}
