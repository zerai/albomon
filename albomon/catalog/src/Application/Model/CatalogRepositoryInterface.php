<?php declare(strict_types=1);

namespace Albomon\Catalog\Application\Model;

interface CatalogRepositoryInterface
{
    public function save(CatalogItem ...$items): void;

    public function getItems(): array;

    public function totalItems(): int;
}
