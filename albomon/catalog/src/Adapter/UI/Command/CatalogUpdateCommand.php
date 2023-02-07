<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter\UI\Command;

use Albomon\Catalog\Application\CatalogUpdaterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CatalogUpdateCommand extends Command
{
    protected static $defaultName = 'albomon:catalog:update';

    public function __construct(
        private CatalogUpdaterInterface $updater
    ) {
        parent::__construct();

        $this->setDescription('Aggiorna i dati del catalogo albi.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<info>Albomon: starting update...</info>");

        $this->updater->updateCatalog();

        return 0;
    }
}
