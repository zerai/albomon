<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter\GithubDataDownloader;

use Albomon\Catalog\Application\ComuniDataDownloaderInterface;

class GithubDataDownloader implements ComuniDataDownloaderInterface
{
    public function __construct(
        private readonly GithubHttpClient $httpClient
    ) {
    }

    public function downloadComuniData(): array
    {
        $comuniCatalogData = [];

        $comuniMarkdownFileIndex = $this->getComuniMarkdownFileIndex();

        foreach ($comuniMarkdownFileIndex as $markdownFileUrl) {
            $markdown = $this->httpClient->getComuneMarkdownFile($markdownFileUrl)->getBody()->getContents();

            $comuniCatalogData[] = $this->convertMarkdownToCatalogItem($markdown);
        }

        return $comuniCatalogData;
    }

    public function getComuniMarkdownFileIndex(): array
    {
        $comuniMarkdownFileIndex = [];

        try {
            $responseData = json_decode($this->httpClient->getComuniMarkdownFileIndex()->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
            foreach ($responseData as $dataItem) {
                if ('_index.md' === $dataItem->name ||
                    'potenza.md' === $dataItem->name ||
                    'trabia.md' === $dataItem->name
                ) {
                    continue;
                }
                $comuniMarkdownFileIndex[] = $dataItem->url;
            }

            return $comuniMarkdownFileIndex;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function convertMarkdownToCatalogItem(string $markdownContent): array
    {
        $catalogItem = MarkdownToCatalogItemConverter::createFromMarkdownContent($markdownContent);

        return $catalogItem->asArray();
    }
}
