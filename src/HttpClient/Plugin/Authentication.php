<?php

namespace OwenVoke\EMSESP\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\VersionBridgePlugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

final class Authentication implements Plugin
{
    use VersionBridgePlugin;

    public function __construct(private readonly string $tokenOrLogin)
    {
    }

    public function doHandleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $request = $request->withHeader(
            'Authorization',
            $this->getAuthorizationHeader()
        );

        return $next($request);
    }

    private function getAuthorizationHeader(): string
    {
        return "Bearer {$this->tokenOrLogin}";
    }
}
