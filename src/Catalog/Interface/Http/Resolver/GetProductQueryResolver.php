<?php

namespace App\Catalog\Interface\Http\Resolver;

use App\Catalog\Application\Query\GetProductQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Uid\Uuid;

class GetProductQueryResolver implements ValueResolverInterface
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === GetProductQuery::class;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $productId = $request->attributes->get('id');

        yield new GetProductQuery(Uuid::fromString($productId));
    }
}
