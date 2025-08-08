<?php

namespace App\Catalog\Interface\Http\Resolver;

use App\Catalog\Application\Query\GetProductQuery;
use App\Catalog\Application\Query\GetProductsQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class GetProductsQueryResolver implements ValueResolverInterface
{
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (GetProductsQuery::class !== $argument->getType()) {
            return [];
        }

        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $order = $request->query->get('order', 'name');
        $direction = $request->query->get('direction', 'asc');

        yield new GetProductsQuery($page, $limit, $order, $direction);
    }
}
