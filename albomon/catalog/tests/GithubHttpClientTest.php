<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog;

use Albomon\Catalog\Adapter\GithubHttpClient;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GithubHttpClientTest extends KernelTestCase
{
    public function testGetComuniMarkdownFileIndex()
    {
        self::bootKernel();

        $container = self::$kernel->getContainer();

        $githubRepositoryHttpClient = $container->get(GithubHttpClient::class);

        $result = $githubRepositoryHttpClient->getComuniMarkdownFileIndex();

        self::assertNotEmpty($result);
    }

    public function testGetComuneMarkdownFile()
    {
        self::bootKernel();

        $container = self::$kernel->getContainer();

        $githubRepositoryHttpClient = $container->get(GithubHttpClient::class);

        $result = $githubRepositoryHttpClient->getComuneMarkdownFile('https://api.github.com/repos/ondata/albopopTwoDotZero/contents/content/comune/accumoli.md');

        self::assertNotEmpty($result);
    }
}
