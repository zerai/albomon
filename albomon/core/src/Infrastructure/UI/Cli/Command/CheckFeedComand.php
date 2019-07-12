<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Command;

use Albomon\Core\Application\MonitorApplicationService\MonitorApplicationService;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckFeedComand extends Command
{
    /** @var MonitorApplicationService */
    private $monitorService;

    public function __construct(MonitorApplicationService $monitorService)
    {
        parent::__construct('albomon:check:feed');

        $this->monitorService = $monitorService;

        $this->setDescription('Console command check a single albo');
    }

    protected function configure()
    {
        $this
            ->addArgument('feed_url', InputArgument::REQUIRED, 'feed url dell\'albo?')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        // TODO remove
        $AlboPopSpecValidation = 'Non Rilevato';

        $io = new SymfonyStyle($input, $output);

        if ($input->isInteractive()) {

            $io->text('Inizio scansione feed albo...');

            $io->note('Il tempo necessario alla scansione può variare in base al tipo di connessione e  alle condizioni della rete.');
        }

        $feedUrl = $input->getArgument('feed_url'); //var_dump($feedUrl);

        $output->writeln("<info>Albo: $feedUrl</info>");

        $monitorResult = $this->monitorService->checkAlbo($feedUrl);

        if ($input->isInteractive()) {

            if (!$monitorResult->httpStatus()) {

                $output->writeln('<info>Feed Status: </info> <error>NON ATTIVO</error>');

                $output->writeln("<info>AlboPOP Spec. Validation: $AlboPopSpecValidation</info>");

                $output->writeln("<error>Error Message: {$monitorResult->httpError()}</error>");

            } else {

                $output->writeln('<info>Feed Status: ATTIVO</info>');

                $output->writeln("<info>Content Updated At: {$this->formatContentUpdatedAt($monitorResult->lastFeedItemDate())}</info>");

                $output->writeln("<info>AlboPOP Spec. Validation: $AlboPopSpecValidation</info>");
            }
        }

        return null;
    }

    private function formatContentUpdatedAt(DateTime $contenteDateTime): string
    {
        $dateNow = new DateTime('now');

        $diff = $dateNow->diff($contenteDateTime)->days;

        return $contenteDateTime->format('Y-m-d').'  -'.$diff.' gg.';
    }
}
