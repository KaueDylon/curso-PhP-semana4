<?php

declare(strict_types=1);
namespace Todoitapi\App\Http;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Todoitapi\App\Repository\TarefaRepository;
use Todoitapi\App\Service\TarefaService;

class Router
{
    private array $routes = [];
    public function get(string $path, array|callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, array|callable $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function patch(string $path, array|callable $handler): void
    {
        $this->routes['PATCH'][$path] = $handler;
    }

    public function delete(string $path, array|callable $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes[$method] ?? [] as $route => $handler){
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $route);
            if (preg_match("#^{$pattern}$#", $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $body = json_decode(file_get_contents('php://input'), true) ?? [];
                $queryParams = $_GET;

                if (is_array($handler)) {
                    [$class, $method] = $handler;

                    $log = new Logger('logGeral');
                    $repository = new TarefaRepository();
                    $log->pushHandler(new StreamHandler(__DIR__.'/../../public/logGeral.log'));
                    $service = new TarefaService($log, $repository);
                    $controller = new $class($service);
                    echo json_encode($controller->$method($params, $body, $queryParams), JSON_THROW_ON_ERROR);
                } else {
                    echo json_encode($handler($params, $body, $queryParams), JSON_THROW_ON_ERROR);
                }
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['erro' => 'Rota não encontrada']);
    }

}