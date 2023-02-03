<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\Unit;

use Albomon\Catalog\Adapter\GithubDataReader;
use Albomon\Catalog\Application\Model\CatalogRepositoryInterface;
use Albomon\Catalog\Application\UpdateCatalog;
use PHPUnit\Framework\TestCase;

class UpdateCatalogTest extends TestCase
{
    public function testShouldUpdateTheCatalog(): void
    {
        $githubReaderMock = self::getMockBuilder(GithubDataReader::class)
            ->disableOriginalConstructor()
            ->getMock();

        $catalogRepositoryMock = self::getMockBuilder(CatalogRepositoryInterface::class)
            ->getMock();

        $githubReaderMock->expects(self::once())
            ->method('getComuniCatalogData');

        $catalogRepositoryMock->expects(self::once())
            ->method('save');

        $sut = new UpdateCatalog($catalogRepositoryMock, $githubReaderMock);

        $sut->updateCatalog();
    }
}
