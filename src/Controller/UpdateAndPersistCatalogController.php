<?php declare(strict_types=1);

namespace App\Controller;

use Albomon\Catalog\Application\UpdateCatalog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UpdateAndPersistCatalogController extends AbstractController
{
    public function __invoke(UpdateCatalog $catalogUpdater): Response
    {
        $catalogUpdater->updateCatalog();
        return new JsonResponse([]);
    }
}
