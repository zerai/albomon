<?php declare(strict_types=1);

namespace Albomon\Tests\Catalog\Unit;

use Albomon\Catalog\Application\ComuniDataDownloaderInterface;
use Albomon\Catalog\Application\Model\CatalogRepositoryInterface;
use Albomon\Catalog\Application\UpdateCatalog;
use PHPUnit\Framework\TestCase;

class UpdateCatalogTest extends TestCase
{
    public function testShouldUpdateTheCatalog(): void
    {
        $githubReaderMock = self::getMockBuilder(ComuniDataDownloaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $catalogRepositoryMock = self::getMockBuilder(CatalogRepositoryInterface::class)
            ->getMock();

        $githubReaderMock->expects(self::once())
            ->method('downloadComuniData');

        $catalogRepositoryMock->expects(self::once())
            ->method('save');

        $sut = new UpdateCatalog($catalogRepositoryMock, $githubReaderMock);

        $sut->updateCatalog();
    }
}
