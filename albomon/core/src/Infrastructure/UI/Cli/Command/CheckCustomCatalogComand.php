<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Command;

use Albomon\Core\Application\MonitorApplicationService\MonitorApplicationService;
use Albomon\Core\Infrastructure\UI\Cli\Traits\SymfonyStyleTrait;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCustomCatalogComand extends Command
{
    use SymfonyStyleTrait;

    private const CATALOG_FILE_NAME = 'custom-catalog.json';

    /** @var MonitorApplicationService */
    private $monitorService;

    /** @var string */
    private $catalogDir;

    public function __construct(MonitorApplicationService $monitorService, string $catalogDir)
    {
        parent::__construct('albomon:check:custom-catalog');

        $this->monitorService = $monitorService;

        $this->catalogDir = $catalogDir;

        $this->setDescription('Console command check a list of albi');
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        $alboList = $this->getCustomCatalog();

        $AlboPopSpecValidation = 'Non Rilevato';

        $io = $this->getSymfonyStyle($input, $output);

        if ($input->isInteractive()) {
            $io->text('Inizio scansione albi, origine dati: '.self::CATALOG_FILE_NAME);

            $io->text('Il catalogo albi contiene '.count($alboList).' feed da analizzare.');

            $io->note('Il tempo necessario alla scansione può variare in base al tipo di connessione ed alle condizioni della rete.');
        }

        $monitorResultCollection = $this->monitorService->checkAlboList($alboList);

        if ($input->isInteractive()) {
            $section = $output->section();

            $table = new Table($section);

            $table
                ->setHeaders(['Feed', 'Feed Status', 'Spec Status', 'Content Updated At', 'Error'])
            ;

            $table->render();

            foreach ($monitorResultCollection as $monitorResult) {
                if (!$monitorResult->httpStatus()) {
                    $table->appendRow([$monitorResult->feedUrl(), sprintf('<error>%s</error>', 'NON ATTIVO'), $AlboPopSpecValidation, '', 'server error']);
                } else {
                    $lastFeedItemDateWithDifference = $this->formatContentUpdatedAt($monitorResult->lastFeedItemDate());

                    $table->appendRow([$monitorResult->feedUrl(), 'ATTIVO', $AlboPopSpecValidation, $lastFeedItemDateWithDifference, '']);
                }
            }

            $io->text('Processo di scasione terminato.');
        }

        return null;
    }

    private function getCustomCatalog(): array
    {
        $catalogFile = $this->catalogDir.DIRECTORY_SEPARATOR.self::CATALOG_FILE_NAME;

        if (!file_exists($catalogFile)) {
            throw new \RuntimeException('Catalog file not found. file: '.$catalogFile);
        }

        $strJsonFileContents = file_get_contents($this->catalogDir.DIRECTORY_SEPARATOR.self::CATALOG_FILE_NAME);

        $customCatalog = json_decode((string) $strJsonFileContents, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException('Unable to parse response body into JSON: '.json_last_error());
        }

        return $customCatalog;
    }

    private function formatContentUpdatedAt(DateTime $contenteDateTime): string
    {
        $dateNow = new DateTime('now');

        $diff = $dateNow->diff($contenteDateTime)->days;

        return $contenteDateTime->format('Y-m-d').'  -'.$diff.' gg.';
    }
}
