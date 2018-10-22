<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Log;

class GuzzleClientWrapper
{
    /**
     * The GuzzleHttp Client
     *
     * @var Client
     */
    private $client;

    /**
     * GuzzleRequestWrapper constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Creates multiple log handlers and adds them to the handler stack
     *
     * @param array $messageFormats
     * @return HandlerStack
     */
    private function createLoggingHandlerStack(array $messageFormats)
    {
        $stack = \GuzzleHttp\HandlerStack::create();

        collect($messageFormats)->each(function ($messageFormat) use ($stack) {
            // We'll use unshift instead of push, to add the middleware to the bottom of the stack, not the top
            $stack->unshift($this->createGuzzleLoggingMiddleware($messageFormat));
        });

        return $stack;
    }

    /**
     * Creates a single log handler
     *
     * @param string $messageFormat
     * @return callable
     */
    private function createGuzzleLoggingMiddleware(string $messageFormat)
    {
        return \GuzzleHttp\Middleware::log(Log::getLogger(), new \GuzzleHttp\MessageFormatter($messageFormat));
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array  $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request($method, $uri = '', array $options = [])
    {
        $handlerStack = $this->createLoggingHandlerStack([
            '{method} {uri} HTTP/{version} {req_body}',
            'RESPONSE: {code} - {res_body}',
        ]);

        return $this->client->request($method, $uri, array_merge($options, ['handler' => $handlerStack]));
    }
}
