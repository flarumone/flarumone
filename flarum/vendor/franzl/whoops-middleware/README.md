# PSR-7 middleware for Whoops

A PSR-7 compatible middleware for [Whoops](https://github.com/filp/whoops), the fantastic pretty error handler for PHP.

*Right now, this is only compatible with Zend's Stratigility middleware pipe.*

## Installation

You can install the library using Composer:

    composer require franzl/whoops-middleware

## Usage

To use it, pipe your app through the middleware:

~~~php
$app->pipe(new \Franzl\Middleware\Whoops\Middleware);
~~~

(You should probably do this at the end of your middleware stack, so that errors cannot be handled elsewhere.)
