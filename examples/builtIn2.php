<?php
require __DIR__ . '/../vendor/autoload.php';

use G\HttpServer\Builder;
use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();

$app->get('/', function () {
        return 'Hello';
    });

$app->get('/hello/{name}', function ($name) {
        return 'Hello ' . $name;
    });

Builder::createBuiltInServer(function (Request $request) use ($app) {
        return $app->handle($request);
    })->listen(1337);