<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Command;

use Albomon\Core\Application\MonitorApplicationService\MonitorApplicationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckAlboComand extends Command
{
    /** @var MonitorApplicationService */
    private $monitorService;

    public function __construct(MonitorApplicationService $monitorService)
    {
        parent::__construct('albomon:monitor:check-albo');

        $this->monitorService = $monitorService;

        $this->setDescription('Console command check a single albo');
    }

    protected function configure()
    {
        $this
            ->addArgument('feed_url', InputArgument::REQUIRED, 'albo url?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $io = new SymfonyStyle($input, $output);

        $io->text('Check RSS feed...');

        $feedUrl = $input->getArgument('feed_url'); //var_dump($feedUrl);

        $output->writeln("<info>Albo: $feedUrl</info>");

        $monitorResult = $this->monitorService->checkAlbo($feedUrl);

        $AlboPopSpecValidation = 'Non Rilevato';

        if ($input->isInteractive()) {
            if (!$monitorResult->httpStatus()) {
                $output->writeln('<info>Feed Status: NON ATTIVO</info>');
                $output->writeln("<info>AlboPOP Spec. Validation: $AlboPopSpecValidation</info>");
                $output->writeln("<error>Error Message: {$monitorResult->httpError()}</error>");
            } else {
                $output->writeln('<info>Feed Status: ATTIVO</info>');
                $output->writeln("<info>AlboPOP Spec. Validation: $AlboPopSpecValidation</info>");
            }
        }

        return null;
    }
}
