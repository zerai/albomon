<?php

declare(strict_types=1);

namespace Albomon\Core\Infrastructure\UI\Cli\Command;

use Albomon\Core\Application\MonitorApplicationService\MonitorApplicationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckAlboListComand extends Command
{
    private const CATALOG_FILE_NAME = 'custom-catalog.json';

    /** @var MonitorApplicationService */
    private $monitorService;

    /** @var string */
    private $catalogDir;

    public function __construct(MonitorApplicationService $monitorService, string $catalogDir)
    {
        parent::__construct('albomon:monitor:check-albo-list');

        $this->monitorService = $monitorService;
        $this->catalogDir = $catalogDir;

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
        $alboList = $this->getCustomCatalog();

        //$io = new SymfonyStyle($input, $output);

        //$io->text('Check RSS feed list...');

        // TODO cambiare formattazione risultati, usare tabella....

        $monitorResultCollection = $this->monitorService->checkAlboList($alboList);

        // TODO remove
        $AlboPopSpecValidation = 'Non Rilevato';

        if ($input->isInteractive()) {
            $section = $output->section();
            $table = new Table($section);
            $table
                ->setHeaders(['Feed', 'Feed Status', 'Spec Status', 'Error'])
            ;
            $table->render();

            foreach ($monitorResultCollection as $monitorResult) {
                if (!$monitorResult->httpStatus()) {
                    $table->appendRow(['NOME', 'NON ATTIVO', $AlboPopSpecValidation, $monitorResult->httpError()]);
                } else {
                    $table->appendRow(['NOME', 'ATTIVO', $AlboPopSpecValidation, '']);
                }
            }
        }

        return null;
    }

    public function getCustomCatalog(): array
    {
        // TODO check exist before open throw exception or message in console
        $strJsonFileContents = file_get_contents($this->catalogDir.DIRECTORY_SEPARATOR.self::CATALOG_FILE_NAME);

        $customCatalog = json_decode($strJsonFileContents, true);

        return $customCatalog;
    }
}
