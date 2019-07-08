<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Command;

use Albomon\Core\Application\MonitorApplicationService\MonitorApplicationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckAlboListComand extends Command
{
    /** @var MonitorApplicationService */
    private $monitorService;

    public function __construct(MonitorApplicationService $monitorService)
    {
        parent::__construct('albomon:monitor:check-albo-list');

        $this->monitorService = $monitorService;

        $this->setDescription('Console command check a list of albi');
    }

    protected function configure()
    {
//        $this
//            ->addArgument('feed_url', InputArgument::REQUIRED, 'albo url?')
//        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        // TODO remove
        $alboList = [
            'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml',
            'http://feeds.ricostruzionetrasparente.it/albi_pretori/Muccia_feed.xml',
        ];

        $io = new SymfonyStyle($input, $output);

        $io->text('Check RSS feed list...');

        //$feedUrl = $input->getArgument('feed_url'); //var_dump($feedUrl);

        //$output->writeln("<info>Albo: $feedUrl</info>");

        $monitorResultCollection = $this->monitorService->checkAlboList($alboList);

        $AlboPopSpecValidation = 'Non Rilevato';

        if ($input->isInteractive()) {
            foreach ($monitorResultCollection as $monitorResult) {
                //$output->writeln("<info>Albo: $monitorResult[0]</info>");
                if (!$monitorResult->httpStatus()) {
                    $output->writeln('<info>Feed Status: NON ATTIVO</info>');
                    $output->writeln("<info>AlboPOP Spec. Validation: $AlboPopSpecValidation</info>");
                    $output->writeln("<error>Error Message: {$monitorResult->httpError()}</error>");
                } else {
                    $output->writeln('<info>Feed Status: ATTIVO</info>');
                    $output->writeln("<info>AlboPOP Spec. Validation: $AlboPopSpecValidation</info>");
                }
            }
        }

        return null;
    }
}
