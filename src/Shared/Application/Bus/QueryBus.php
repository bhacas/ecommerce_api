<?php

namespace App\Shared\Application\Bus;

final readonly class QueryBus
{
    private array $handlers;

    public function __construct(iterable $queryHandlers)
    {
        $handlersMap = [];
        foreach ($queryHandlers as $handler) {
            $reflection = new \ReflectionMethod($handler, '__invoke');
            $parameters = $reflection->getParameters();
            $queryClass = $parameters[0]->getType()->getName();

            $handlersMap[$queryClass] = $handler;
        }
        $this->handlers = $handlersMap;
    }

    public function handle(object $query): mixed
    {
        $class = get_class($query);
        if (!isset($this->handlers[$class])) {
            throw new \RuntimeException("No handler for $class");
        }
        return call_user_func($this->handlers[$class], $query);
    }
}
