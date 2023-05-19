<?php declare(strict_types=1);

namespace Albomon\Catalog\Application;

use Albomon\Catalog\Application\Model\CatalogItem;
use Albomon\Catalog\Application\Model\CatalogRepositoryInterface;
use Ramsey\Uuid\Uuid;

class UpdateCatalog implements CatalogUpdaterInterface
{
    public function __construct(
        private CatalogRepositoryInterface $catalogRepository,
        private ComuniDataDownloaderInterface $githubDataDownloader,
    ) {
    }

    public function updateCatalog(): void
    {
        $this->catalogRepository->reset();
        $catalogItems = [];
        $comuniData = $this->githubDataDownloader->downloadComuniData();

        foreach ($comuniData as $comune) {
            $catalogItems[] = CatalogItem::with(Uuid::uuid4()->toString(), $comune['title'], $comune['rss']);
        }

        $this->catalogRepository->save(...$catalogItems);
    }
}
