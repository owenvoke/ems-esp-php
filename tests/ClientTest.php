<?php

declare(strict_types=1);

use OwenVoke\EMSESP\Api\AnalogSensor;
use OwenVoke\EMSESP\Api\Custom;
use OwenVoke\EMSESP\Api\Device;
use OwenVoke\EMSESP\Api\System;
use OwenVoke\EMSESP\Api\TemperatureSensor;
use OwenVoke\EMSESP\Client;

it('gets instances from the client', function () {
    $client = new Client();

    expect($client->analogSensor())->toBeInstanceOf(AnalogSensor::class)
        ->and($client->custom())->toBeInstanceOf(Custom::class)
        ->and($client->customEntities())->toBeInstanceOf(Custom::class)
        ->and($client->device())->toBeInstanceOf(Device::class)
        ->and($client->devices())->toBeInstanceOf(Device::class)
        ->and($client->system())->toBeInstanceOf(System::class)
        ->and($client->temperatureSensor())->toBeInstanceOf(TemperatureSensor::class);
});
