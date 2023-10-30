<?php

declare(strict_types=1);

namespace OwenVoke\EMSESP\Api;

class AnalogSensor extends AbstractApi
{
    public function info(): array
    {
        return $this->get('/analogsensor/info');
    }

    public function commands(): array
    {
        return $this->get('/analogsensor/commands');
    }

    public function set(string $id, string $value): array
    {
        return $this->post('/analogsensor/setvalue', [
            'id' => $id,
            'value' => $value,
        ]);
    }
}
