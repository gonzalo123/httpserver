<?php
require __DIR__ . '/../vendor/autoload.php';

use G\HttpServer\Builder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

Builder::createBuiltInServer(function (Request $request) {
        return "Hello " . $request->get('name');
    })->listen(1337);