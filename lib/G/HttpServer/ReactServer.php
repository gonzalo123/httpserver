<?php

namespace G\HttpServer;

use React;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReactServer
{
    private $loop;
    private $socket;
    private $requestHandler;

    public function __construct(React\EventLoop\StreamSelectLoop $loop, React\Socket\Server $socket)
    {
        $this->loop = $loop;
        $this->socket = $socket;
    }

    public function registerHandler(callable $requestHandler)
    {
        $this->requestHandler = function (React\Http\Request $request, React\Http\Response $response) use ($requestHandler) {
            $this->handle($request, $response, $requestHandler);
        };
    }

    private function handle(React\Http\Request $request, React\Http\Response $response, $requestHandler)
    {
        $sfRequest = Request::create($request->getPath(), $request->getMethod(), $request->getQuery());
        $output = call_user_func_array($requestHandler, [$sfRequest]);
        if ($output instanceof Response) {
            $response->writeHead($output->getStatusCode(), $output->headers->all());
            $response->end($output->getContent());
        } else {
            $response->writeHead(200, array('Content-Type' => 'text/plain'));
            $response->end($output);
        }
    }

    public function listen($port, $host='0.0.0.0')
    {
        $http = new React\Http\Server($this->socket, $this->loop);
        $http->on('request', $this->requestHandler);
        $this->socket->listen($port, $host);
        $this->loop->run();
    }
}