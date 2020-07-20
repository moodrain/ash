<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Message\Response as ReactResponse;
use React\Http\Server;
use ReactRequestException;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

class Serve extends Command
{

    protected $signature = 'serve {host=127.0.0.1} {port=8000}';

    protected $description = 'Command description';

    public function handle()
    {
        $factory = new Psr17Factory;
        $psrHttpFactory = new PsrHttpFactory($factory, $factory, $factory, $factory);
        $httpFoundationFactory = new HttpFoundationFactory;
        $kernel = app()->make(\Illuminate\Contracts\Http\Kernel::class);

        $loop = Factory::create();
        $server = new Server($loop, function(ServerRequestInterface $request) use ($psrHttpFactory, $kernel, $httpFoundationFactory) {
            try {
                $request = Request::createFromBase($httpFoundationFactory->createRequest($request));
                $response = $kernel->handle($request);
                $kernel->terminate($request, $response);
                return $psrHttpFactory->createResponse($response);
            } catch (\Exception $e) {
                throw new ReactRequestException($e, $request);
            }
        });
        $server->on('error', function (Exception $e) use ($psrHttpFactory) {
            $handler = resolve(\App\Exceptions\Handler::class);
            $handler->report($e);
            if ($e instanceof ReactRequestException &&  $e->hasRequest()) {
                return $psrHttpFactory->createResponse($handler->render($e->getRequest(), $e));
            } else {
                return new ReactResponse(500);
            }
        });
        $server->listen(new \React\Socket\Server('127.0.0.1:8080', $loop));
        $loop->run();
    }
}


