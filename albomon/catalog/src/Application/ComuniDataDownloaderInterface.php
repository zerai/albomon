<?php declare(strict_types=1);

namespace Albomon\Catalog\Application;

interface ComuniDataDownloaderInterface
{
    public function downloadComuniData(): array;
}
