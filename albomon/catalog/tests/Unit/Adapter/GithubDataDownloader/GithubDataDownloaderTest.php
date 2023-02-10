<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\Unit\Adapter\GithubDataDownloader;

use Albomon\Catalog\Adapter\GithubDataDownloader\GithubDataDownloader;
use Albomon\Catalog\Adapter\GithubDataDownloader\GithubHttpClient;
use Albomon\Catalog\Application\ComuniDataDownloaderInterface;
use PHPUnit\Framework\TestCase;

class GithubDataDownloaderTest extends TestCase
{
    public function testImplementInterface(): void
    {
        $githubHttpClientMock = self::getMockBuilder(GithubHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sut = new GithubDataDownloader($githubHttpClientMock);

        self::assertInstanceOf(ComuniDataDownloaderInterface::class, $sut);
    }

    public function testConstruct(): void
    {
        $githubHttpClientMock = self::getMockBuilder(GithubHttpClient::class)
            ->disableOriginalConstructor()
            ->getMock();
        $sut = new GithubDataDownloader($githubHttpClientMock);

        self::assertInstanceOf(ComuniDataDownloaderInterface::class, $sut);
    }

    public function testShouldDownloadComuniDataFromGhithub(): void
    {
        self::markTestSkipped();
        $githubHttpClientMock = self::getMockBuilder(GithubHttpClient::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getComuniMarkdownFileIndex', 'getComuneMarkdownFile'])
            ->getMock();
        $sut = new GithubDataDownloader($githubHttpClientMock);

        $response = self::createMock(\Psr\Http\Message\ResponseInterface::class);
        $githubHttpClientMock
            ->expects(self::once())
            ->method('getComuniMarkdownFileIndex')
            ->willReturn($response);

        $result = $sut->downloadComuniData();
    }
}
