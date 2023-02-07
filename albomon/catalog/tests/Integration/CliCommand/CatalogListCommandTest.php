<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\Integration\CliCommand;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CatalogListCommandTest extends KernelTestCase
{
    private ?CommandTester $commandTester = null;

    private Command $command;

    protected function setUp(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $this->command = $application->find('albomon:catalog:list');
        $this->commandTester = new CommandTester($this->command);
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_can_execute(): void
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
        ]);

        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('Albomon: catalogo comuni...', $output);
    }

    protected function tearDown(): void
    {
        $this->commandTester = null;
        parent::tearDown();
    }
}
