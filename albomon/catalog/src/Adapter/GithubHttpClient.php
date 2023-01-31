<?php declare(strict_types=1);

namespace Albomon\Catalog\Adapter;

use GuzzleHttp\Psr7\Request;
use Http\Client\HttpClient;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class GithubHttpClient
{
    private const GH_ORGANIZATION = 'ondata';

    private const GH_REPO = 'albopopTwoDotZero';

    private const MARKDOWN_FILE_INDEX_URL = 'content/comune';

    public function __construct(
        private HttpClient $httpClient
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getComuniMarkdownFileIndex(): ResponseInterface
    {
        /**
         * Github api docs.
         * @see https://docs.github.com/en/rest/repos/contents?apiVersion=2022-11-28
         */
        $url = sprintf('https://api.github.com/repos/%s/%s/contents/%s', self::GH_ORGANIZATION, self::GH_REPO, self::MARKDOWN_FILE_INDEX_URL);

        return $this->httpClient->sendRequest(new Request('GET', $url, [
            'Accept' => 'application/vnd.github+json',
        ]));
    }

    /**
     * @throws ClientExceptionInterface
     */
    public function getComuneMarkdownFile(string $markdownFileUrl): ResponseInterface
    {
        return $this->httpClient->sendRequest(new Request('GET', $markdownFileUrl, [
            'Accept' => 'application/vnd.github.raw',
        ]));
    }
}
