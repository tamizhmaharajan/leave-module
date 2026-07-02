<?php

class Router
{
    private array $routes = [];
    public function add(string $method, string $route, array $action): void
    {
        $this->routes[] =[
            "method" => strtoupper($method),
            "route" => $route,
            "action" => $action
        ];
    }
    public function dispatch(string $method, string $url)
}