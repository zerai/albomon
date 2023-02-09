<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter\UI\Command;

use Albomon\Catalog\Adapter\Persistence\CatalogRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CatalogListCommand extends Command
{
    protected static $defaultName = 'albomon:catalog:list';

    public function __construct(
        private CatalogRepository $repository,
    ) {
        parent::__construct();

        $this->setDescription('Visualizza elementi nel catalogo.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("<info>Albomon: catalogo comuni...</info>");

        $items = $this->getCatalogItems();

        $table = new Table($output);

        $table->setHeaders(['Nome', 'Feed']);

        foreach ($items as $item) {
            $table->addRow([trim($item[1]), trim($item[2])]);
        }
        $table->render();

        return 0;
    }

    private function getCatalogItems(): array
    {
        try {
            $catalogItems = $this->repository->getItems();
        } catch (\Exception) {
            throw new \RuntimeException('Errore: non è possibile accedere al catalogo.');
        }
        return $catalogItems;
    }
}
