<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\Integration\CliCommand;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class CatalogUpdateCommandTest extends KernelTestCase
{
    private ?CommandTester $commandTester = null;

    private Command $command;

    protected function setUp(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $this->command = $application->find('albomon:catalog:update');
        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * @test
     */
    public function it_can_execute(): void
    {
        try {
            $this->commandTester->execute([
                'command' => $this->command->getName(),
            ]);
        } catch (\Exception) {
            // dd($e);
            //self::markTestSkipped('Hit Github Api limit');
        }

        $output = $this->commandTester->getDisplay();

        $this->assertStringContainsString('Albomon: inizio aggiornamento...', $output);
    }

    protected function tearDown(): void
    {
        $this->commandTester = null;
        parent::tearDown();
    }
}
