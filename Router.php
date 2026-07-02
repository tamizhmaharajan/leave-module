<?php

class Router
{
    private array $routes = [];

    public function add(string $method, string $pattern, callable $handler): void
    {
        $this->routes[] = [
            "method" => strtoupper($method),
            "pattern" => $pattern,
            "handler" => $handler
        ];
    }

    public function dispatch(string $method, string $path): void
    {
        foreach ($this->routes as $route) {
            if ($route["method"] !== strtoupper($method)) {
                continue;
            }

            $params = $this->match($route["pattern"], $path);

            if ($params !== null) {
                call_user_func_array($route["handler"], $params);
                return;
            }
        }

        http_response_code(404);

        echo json_encode([
            "status" => false,
            "message" => "Route Not Found"
        ]);
    }

    private function match(string $pattern, string $path): ?array
    {
        $pattern_parts = array_values(array_filter(explode("/", $pattern), "strlen"));
        $path_parts = array_values(array_filter(explode("/", $path), "strlen"));

        if (count($pattern_parts) !== count($path_parts)) {
            return null;
        }

        $params = [];

        foreach ($pattern_parts as $index => $part) 
        {

            if (preg_match('/^{.+}$/', $part)) 
            {
                $params[] = $path_parts[$index];

            }elseif ($part !== $path_parts[$index]) {
                return null;
            }
        }

        return $params;
    }
}