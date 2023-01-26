<?php declare(strict_types=1);

namespace Albomon\Catalog\Application;

interface CatalogUpdaterInterface
{
    public function updateCatalog(): void;
}
