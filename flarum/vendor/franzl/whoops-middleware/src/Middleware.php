<?php

namespace Franzl\Middleware\Whoops;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Zend\Diactoros\Response\StringResponse;
use Zend\Stratigility\ErrorMiddlewareInterface;

class Middleware implements ErrorMiddlewareInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke($error, Request $request, Response $response, callable $out = null)
    {
        $whoops = new Run();
        $whoops->pushHandler(new PrettyPageHandler());
        $whoops->register();

        $method = Run::EXCEPTION_HANDLER;

        ob_start();
        $whoops->$method($error);
        $response = ob_get_clean();

        return StringResponse::html($response, 500);
    }
}
