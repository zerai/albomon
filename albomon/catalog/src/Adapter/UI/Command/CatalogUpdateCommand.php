<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter\UI\Command;

use Albomon\Catalog\Application\CatalogUpdaterInterface;
use Albomon\Catalog\Application\Model\CatalogRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CatalogUpdateCommand extends Command
{
    protected static $defaultName = 'albomon:catalog:update';

    public function __construct(
        private readonly CatalogUpdaterInterface $updater,
        private readonly CatalogRepositoryInterface $catalogRepository,
    ) {
        parent::__construct();

        $this->setDescription('Aggiorna i dati del catalogo albi.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<info>Albomon: inizio aggiornamento...</info>");

        $totalItem = $this->catalogRepository->totalItems();
        $output->writeln("<info>Stat. catalogo: Total item $totalItem</info>");

        $this->updater->updateCatalog();

        $output->writeln("<info>Aggiornamento terminato...</info>");

        $newTotalItem = $this->catalogRepository->totalItems();
        $output->writeln("<info>Total item dopo aggiornamento $newTotalItem</info>");

        return 0;
    }
}
