<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog;

use Albomon\Catalog\Adapter\GithubDataReader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GithubDataReaderTest extends kernelTestCase
{
    public function testComuniCatalogData()
    {
        self::markTestSkipped();
        self::bootKernel();

        $container = self::$kernel->getContainer();

        $githubDataReader = $container->get(GithubDataReader::class);

        $result = $githubDataReader->getComuniCatalogData();

        self::assertNotEmpty($result);
    }
}
