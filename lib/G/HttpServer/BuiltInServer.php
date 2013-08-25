<?php

namespace G\HttpServer;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BuiltInServer
{
    private $requestHandler;

    public function listen($port, $host = '0.0.0.0')
    {
        if ($this->isCli()) {
            $this->startServer($port, $host);
        } else {
            $this->handle();
        }
    }

    public function registerHandler(callable $requestHandler)
    {
        $this->requestHandler = $requestHandler;
    }

    private function isCli()
    {
        return php_sapi_name() == 'cli';
    }

    private function startServer($port, $host)
    {
        $command = escapeshellcmd(
            sprintf(
                '%s -S %s -t %s %s',
                PHP_BINARY,
                "{$host}:{$port}",
                $this->getDocumentRoot(),
                $this->getRouter()
            )
        );

        proc_open($command, [0 => STDIN, 1 => STDOUT, 2 => STDERR], $pipes);
    }

    private function handle()
    {
        $output = call_user_func_array($this->requestHandler, [Request::createFromGlobals()]);

        if ($output instanceof Response) {
            $response = $output;
        } else {
            $response = new Response($output);
        }

        $response->send();
    }

    private function getDocumentRoot()
    {
        return dirname(realpath($_SERVER['argv'][0]));
    }

    private function getRouter()
    {
        return realpath($_SERVER['argv'][0]);
    }
}