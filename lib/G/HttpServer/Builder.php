<?php

namespace G\HttpServer;

use React;

class Builder
{
    public static function createBuiltInServer($requestHandler)
    {
        $server = new BuiltInServer();
        $server->registerHandler($requestHandler);

        return $server;
    }

    public static function createReactServer($requestHandler)
    {
        $loop   = React\EventLoop\Factory::create();
        $socket = new React\Socket\Server($loop);

        $server = new ReactServer($loop, $socket);
        $server->registerHandler($requestHandler);

        return $server;
    }
}