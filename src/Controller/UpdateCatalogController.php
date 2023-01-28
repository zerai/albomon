<?php declare(strict_types=1);

namespace App\Controller;

use Albomon\Catalog\Adapter\GithubDataReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateCatalogController extends AbstractController
{
    /**
     * @Route("/catalog/update", name="app_catalog_update")
     */
    public function __invoke(GithubDataReader $reader): Response
    {
        return new JsonResponse(json_encode($reader->getComuniCatalogData(), JSON_THROW_ON_ERROR));
    }
}
