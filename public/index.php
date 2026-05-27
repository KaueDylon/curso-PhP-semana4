<?php

declare(strict_types=1);

use Todoitapi\App\Http\Router;
use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once __DIR__ . '/../vendor/autoload.php';

header('Content-Type: application/json; charset=utf-8');

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->safeLoad();
$log = new Logger('logGeral');
$log->pushHandler(new StreamHandler(__DIR__.'/logGeral.log', Logger::DEBUG));

$router = new Router();

require_once __DIR__ .'/../src/Controller/routes.php';

try {
    $router->dispatch();
} catch (JsonException $e) {
    echo $e->getMessage();
}
