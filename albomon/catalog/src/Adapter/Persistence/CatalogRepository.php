<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter\Persistence;

use Albomon\Catalog\Application\Model\CatalogItem;
use Albomon\Catalog\Application\Model\CatalogRepositoryInterface;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

class CatalogRepository implements CatalogRepositoryInterface
{
    private array $items = [];

    public function __construct(
        private string $catalogDataDirectory,
        private string $comuniCatalogFilename
    ) {
        Assert::stringNotEmpty($this->catalogDataDirectory, 'Expected a catalog directory parameter');
        if (! str_ends_with($comuniCatalogFilename, '.json')) {
            throw new InvalidArgumentException('Expected a filename with "json" extension');
        }
        $this->LoadFromFilesystem();
    }

    public function save(CatalogItem ...$items): void
    {
        foreach ($items as $item) {
            $this->items[$item->identity()] = [
                $item->identity() => $item->rssFeedUrl(),
            ];
        }

        $this->persist();
    }

    public function itemExist(string $identity): bool
    {
        $result = false;
        if (\array_key_exists($identity, $this->getItems())) {
            $result = true;
        }

        return $result;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    private function persist(): void
    {
        $path = $this->catalogDataDirectory . $this->comuniCatalogFilename;
        $jsonContent = json_encode($this->getItems(), JSON_PRETTY_PRINT);
        $fp = fopen($path, 'w');
        fwrite($fp, $jsonContent);
        fclose($fp);
    }

    private function LoadFromFilesystem(): void
    {
        $filePath = $this->catalogDataDirectory . $this->comuniCatalogFilename;
        if (file_exists($filePath)) {
            $jsonContent = file_get_contents($filePath);
            $this->items = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        }
    }
}
