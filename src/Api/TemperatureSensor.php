<?php

declare(strict_types=1);

namespace OwenVoke\EMSESP\Api;

class TemperatureSensor extends AbstractApi
{
    public function info(): array
    {
        return $this->get('/temperaturesensor/info');
    }
}
