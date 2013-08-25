<?php
require __DIR__ . '/../vendor/autoload.php';

use G\HttpServer\Builder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$app = new Silex\Application();
$app['debug'] = true;
$app->get('/', function () {
        return 'Hello';
    });

$app->get('/hello/{name}', function ($name) {
        return 'Hello ' . $name;
    });

Builder::createReactServer(function (Request $request) use ($app) {
        return $app->handle($request);
    })->listen(1337);