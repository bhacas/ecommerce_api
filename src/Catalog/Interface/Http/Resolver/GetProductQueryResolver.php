<?php

namespace App\Catalog\Interface\Http\Resolver;

use App\Catalog\Application\Query\GetProductQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Uid\Uuid;

class GetProductQueryResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (GetProductQuery::class !== $argument->getType()) {
            return [];
        }

        $productId = $request->attributes->get('id');
        $productId = '01987935-1ea9-728e-a9ba-ea21ba0ffec1';

        yield new GetProductQuery(Uuid::fromString($productId));
    }
}
