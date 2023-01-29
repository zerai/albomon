<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter;

class GithubDataReader
{
    private GithubHttpClient $httpClient;

    public function __construct(GithubHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getComuniCatalogData(): array
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
            $responseData = json_decode($this->httpClient->getComuniMarkdownFileIndex()->getBody()->getContents(), null, 512, JSON_THROW_ON_ERROR);
            foreach ($responseData as $dataItem) {
                if ('_index.md' === $dataItem->name ||
                    'altamura.md' === $dataItem->name ||
                    'altopascio.md' === $dataItem->name ||
                    'campli.md' === $dataItem->name ||
                    'crema.md' === $dataItem->name ||
                    'crispiano.md' === $dataItem->name ||
                    'francavillafontana.md' === $dataItem->name ||
                    'isola-del-gran-sasso-ditalia.md' === $dataItem->name ||
                    'montorio-al-vomano.md' === $dataItem->name ||
                    'narni.md' === $dataItem->name ||
                    'offida.md' === $dataItem->name ||
                    'pisticci.md' === $dataItem->name ||
                    'potenza.md' === $dataItem->name ||
                    'teramo.md' === $dataItem->name ||
                    'torresantasusanna.md' === $dataItem->name ||
                    'trabia.md' === $dataItem->name ||
                    'treviso.md' === $dataItem->name
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
