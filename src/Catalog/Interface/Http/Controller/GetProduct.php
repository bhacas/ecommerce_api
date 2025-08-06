<?php

namespace App\Catalog\Interface\Http\Controller;

use App\Catalog\Application\Query\GetProductQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class GetProduct extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $queryBus
    )
    {
    }

    #[Route('/api/products/{id}', name: 'api_get_product', methods: ['GET'])]
    public function __invoke(GetProductQuery $query): JsonResponse
    {
        $envelope = $this->queryBus->dispatch($query);

        $productView = $envelope->last(HandledStamp::class)->getResult();

        return $this->json(
            $productView,
            Response::HTTP_OK,
            []
        );
    }
}
