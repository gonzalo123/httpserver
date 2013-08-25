<?php
require __DIR__ . '/../vendor/autoload.php';

use G\HttpServer\Builder;
use Symfony\Component\HttpFoundation\Request;

Builder::createBuiltInServer(function (Request $request) {
        return "Hello " . $request->get('name');
    })->listen(1337);