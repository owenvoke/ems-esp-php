<?php

declare(strict_types=1);

namespace OwenVoke\EMSESP;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Discovery\Psr17FactoryDiscovery;
use OwenVoke\EMSESP\Api\AbstractApi;
use OwenVoke\EMSESP\Api\AnalogSensor;
use OwenVoke\EMSESP\Api\Custom;
use OwenVoke\EMSESP\Api\Device;
use OwenVoke\EMSESP\Api\System;
use OwenVoke\EMSESP\Api\TemperatureSensor;
use OwenVoke\EMSESP\Exception\BadMethodCallException;
use OwenVoke\EMSESP\Exception\InvalidArgumentException;
use OwenVoke\EMSESP\HttpClient\Builder;
use OwenVoke\EMSESP\HttpClient\Plugin\Authentication;
use OwenVoke\EMSESP\HttpClient\Plugin\PathPrepend;
use Psr\Http\Client\ClientInterface;

/**
 * @method AnalogSensor analogSensor()
 * @method Custom custom()
 * @method Custom customEntities()
 * @method Device device()
 * @method Device devices()
 * @method System system()
 * @method TemperatureSensor temperatureSensor()
 */
final readonly class Client
{
    public function __construct(private Builder $httpClientBuilder = new Builder(), public ?string $url = null)
    {
        $httpClientBuilder->addPlugin(new RedirectPlugin());
        $httpClientBuilder->addPlugin(new AddHostPlugin(Psr17FactoryDiscovery::findUriFactory()->createUri($url ?? 'http://ems-esp.local')));
        $httpClientBuilder->addPlugin(new HeaderDefaultsPlugin([
            'User-Agent' => 'ems-esp-php (https://github.com/owenvoke/ems-esp-php)',
        ]));

        $httpClientBuilder->addHeaderValue('Accept', 'application/json');
        $httpClientBuilder->addPlugin(new PathPrepend('/api'));
    }

    public static function createWithHttpClient(ClientInterface $httpClient): self
    {
        $builder = new Builder($httpClient);

        return new self($builder);
    }

    /** @throws InvalidArgumentException */
    public function api(string $name): AbstractApi
    {
        return match ($name) {
            'analogSensor' => new AnalogSensor($this),
            'custom', 'customEntities' => new Custom($this),
            'device', 'devices' => new Device($this),
            'system' => new System($this),
            'temperatureSensor' => new TemperatureSensor($this),
            default => throw new InvalidArgumentException(sprintf('Undefined api instance called: "%s"', $name)),
        };
    }

    public function authenticate(string $tokenOrLogin): void
    {
        $this->getHttpClientBuilder()->removePlugin(Authentication::class);
        $this->getHttpClientBuilder()->addPlugin(new Authentication($tokenOrLogin));
    }

    public function __call(string $name, array $args): AbstractApi
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $name), $e->getCode(), $e);
        }
    }

    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    public function getHttpClientBuilder(): Builder
    {
        return $this->httpClientBuilder;
    }
}
