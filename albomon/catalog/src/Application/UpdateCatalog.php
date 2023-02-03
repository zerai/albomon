<?php declare(strict_types=1);

namespace Albomon\Catalog\Application;

use Albomon\Catalog\Adapter\GithubDataReader;
use Albomon\Catalog\Application\Model\CatalogItem;
use Albomon\Catalog\Application\Model\CatalogRepositoryInterface;
use Ramsey\Uuid\Uuid;

class UpdateCatalog implements CatalogUpdaterInterface
{
    public function __construct(
        private CatalogRepositoryInterface $catalogRepository,
        private GithubDataReader $githubDataReader,
    ) {
    }

    public function updateCatalog(): void
    {
        $catalogItems = [];
        $comuniData = $this->githubDataReader->getComuniCatalogData();

        foreach ($comuniData as $comune) {
            $catalogItems[] = CatalogItem::with(Uuid::uuid4()->toString(), $comune['rss']);
        }

        $this->catalogRepository->save(...$catalogItems);
    }
}
