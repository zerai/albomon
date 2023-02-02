<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter\Persistence;

use Albomon\Catalog\Application\Model\CatalogItem;
use Albomon\Catalog\Application\Model\CatalogRepositoryInterface;

class CatalogRepository implements CatalogRepositoryInterface
{
    public function __construct(
        private string $catalogDataDirectory,
        private array $items = [],
        private string $comuniCatalogFilename
    ) {
        $this->LoadFromFilesystem();
    }

    public function save(CatalogItem ...$items): void
    {
        foreach ($items as $item) {
            $this->items[] = [
                $item->identity() => $item->rssFeedUrl(),
            ];
        }

        $this->persist();
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function persist(): void
    {
        $path = $this->catalogDataDirectory . $this->comuniCatalogFilename;
        $jsonContent = json_encode($this->getItems(), JSON_PRETTY_PRINT);
        $fp = fopen($path, 'w');
        fwrite($fp, $jsonContent);
        fclose($fp);
    }

    public function LoadFromFilesystem(): void
    {
        $filePath = $this->catalogDataDirectory . $this->comuniCatalogFilename;
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $this->items = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        }
    }
}
