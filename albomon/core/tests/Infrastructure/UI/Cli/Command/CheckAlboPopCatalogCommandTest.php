<?php

declare(strict_types=1);

namespace Albomon\Tests\Core\Infrastructure\UI\Cli\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CheckAlboPopCatalogCommandTest extends KernelTestCase
{
    /** @var CommandTester|null */
    private $commandTester;

    /** @var Command */
    private $command;

    protected function setUp()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $this->command = $application->find('albomon:check:albopop-catalog');
        $this->commandTester = new CommandTester($this->command);
    }

    /** @test */
    public function it_can_execute()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
//            // pass arguments to the helper
//            // prefix the key with two dashes when passing options,
//            // e.g: '--some-option' => 'option_value',
        ]);

        $output = $this->commandTester->getDisplay();

        $this->assertContains('Inizio scansione albi, origine dati: albopop-catalog.json', $output);
        $this->assertContains('Feed Status', $output);
    }
}
