<?php

declare(strict_types=1);

namespace OwenVoke\EMSESP\Api;

class System extends AbstractApi
{
    public function info(): array
    {
        return $this->get('/system/info');
    }

    public function fetch(): array
    {
        return $this->get('/system/fetch');
    }

    public function restart(): array
    {
        return $this->get('/system/restart');
    }

    public function commands(): array
    {
        return $this->get('/system/commands');
    }

    public function send(string $telegram): array
    {
        return $this->postRaw('/system/send', $telegram);
    }
}
