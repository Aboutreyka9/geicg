<?php

namespace App\Core;

use Phroute\Phroute\RouteCollector;

class Router extends RouteCollector
{
    protected array $namedRoutes = [];

    public function get($pattern, $handler, array $filters = []): Route
    {
        parent::get($pattern, $handler, $filters);
        return new Route('GET', $pattern, $this);
    }

    public function post($pattern, $handler, array $filters = []): Route
    {
        parent::post($pattern, $handler, $filters);
        return new Route('POST', $pattern, $this);
    }

    public function addNamedRoute(string $name, string $method, string $pattern): void
    {
        $this->namedRoutes[$name] = [$method, $pattern];
    }

    public function router(string $name, array $params = []): ?string
    {
        if (!isset($this->namedRoutes[$name])) {
            return null;
        }

        [$method, $pattern] = $this->namedRoutes[$name];

        foreach ($params as $key => $value) {
            $pattern = str_replace("{{$key}}", $value, $pattern);
        }

        return $pattern;
    }
}

class Route
{
    private string $method;
    private string $pattern;
    private Router $router;

    public function __construct(string $method, string $pattern, Router $router)
    {
        $this->method = $method;
        $this->pattern = $pattern;
        $this->router = $router;
    }

    public function name(string $name): self
    {
        $this->router->addNamedRoute($name, $this->method, $this->pattern);
        return $this;
    }
}
