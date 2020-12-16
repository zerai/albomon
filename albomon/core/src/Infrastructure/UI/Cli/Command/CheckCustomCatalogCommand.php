<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Command;

use Albomon\Core\Application\MonitorApplicationService\MonitorApplicationService;
use Albomon\Core\Application\Service\ReportManager\ReportManagerInterface;
use Albomon\Core\Infrastructure\UI\Cli\Traits\AlboResultStyleTrait;
use Albomon\Core\Infrastructure\UI\Cli\Traits\CatalogFileTrait;
use Albomon\Core\Infrastructure\UI\Cli\Traits\SymfonyStyleTrait;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCustomCatalogCommand extends Command
{
    use AlboResultStyleTrait;
    use CatalogFileTrait;
    use SymfonyStyleTrait;

    private const CATALOG_FILE_NAME = 'custom-catalog.json';

    private const XML_SPEC_VALIDATION = 'Non Rilevato';

    /** @var MonitorApplicationService */
    private $monitorService;

    /** @var ReportManagerInterface */
    private $reportManager;

    /** @var string */
    private $catalogDir;

    /** @var string */
    private $reportDir;

    public function __construct(MonitorApplicationService $monitorService, ReportManagerInterface $reportManager, string $catalogDir, string $reportDir)
    {
        parent::__construct('albomon:check:custom-catalog');

        $this->monitorService = $monitorService;

        $this->reportManager = $reportManager;

        $this->catalogDir = $catalogDir;

        $this->reportDir = $reportDir;

        $this->setDescription('Scansione del catalogo albi personale');
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        //TODO 'Console BUG'    https://github.com/symfony/symfony/issues/29746

        $alboList = $this->getCatalog($this->catalogDir, self::CATALOG_FILE_NAME);

        $io = $this->getSymfonyStyle($input, $output);

        $io->text('Inizio scansione albi, origine dati: '.self::CATALOG_FILE_NAME);

        $io->text('Il catalogo albi contiene '.\count($alboList).' feed da analizzare.');

        $io->note('Il tempo necessario alla scansione può variare in base al tipo di connessione ed alle condizioni della rete.');

        $progressBar = new ProgressBar($output, \count($alboList));

        $progressBar->start();

        $table = new Table($output);

        $table->setHeaders(['Feed', 'Feed Status', 'Spec Status', 'Content Updated At', 'Error']);

        foreach ($alboList as $alboUrl) {
            foreach ($alboUrl as $valueUrl) {
                $monitorResult = $this->monitorService->checkAlbo($valueUrl);
                $this->formatTableRow($monitorResult, $table);
            }
            $progressBar->advance();
        }

        $progressBar->finish();

        $output->writeln('');

        $table->render();

        $this->reportManager->generateReport();

        $io->text('Processo di scasione terminato.');

        return 0;
    }
}
