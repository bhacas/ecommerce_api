<?php

namespace App\Catalog\Interface\Http\Controller;

use App\Catalog\Application\Query\GetProductQuery;
use App\Shared\Application\Bus\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[AsController]
final class GetProduct
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly SerializerInterface $serializer,
    )
    {
    }

    #[Route('/api/products/{id}', name: 'api_get_product', methods: ['GET'])]
    public function __invoke(Request $request, string $id)
    {
        $query = new GetProductQuery(Uuid::fromString($id));
        $product = $this->queryBus->handle($query);
        $data = $this->serializer->serialize($product, 'jsonld');

        return new JsonResponse($data, Response::HTTP_OK, [], true);

    }
}
